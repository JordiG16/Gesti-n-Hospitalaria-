<?php
session_start();

if (!isset($_SESSION['usuarios'])) {
    header("Location: ../login/login.php");
    exit();
}

include(__DIR__ . "/../includes/conexiones.php");
include(__DIR__ . "/../includes/funciones.php");

$mensaje = "";
$tipo_msg = "";

#PROCESAR EL CAMBIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $pass_actual=$_POST['pass_actual'];
    $pass_nueva=$_POST['pass_nueva'];
    $pass_confirm=$_POST['pass_confirm'];
    $usuario_logueado=$_SESSION['usuario'];

    #Validaciones básicas
    if (empty($pass_actual) || empty($pass_nueva) || empty($pass_confirm)) {
        $mensaje="Todos los campos son obligatorios.";
        $tipo_msg="error";
    } elseif ($pass_nueva !== $pass_confirm) {
        $mensaje="Las contraseñas nuevas no coinciden.";
        $tipo_msg="error";
    } else {
        #Validación de Seguridad (Reutilizamos logica de mi funcuion)
        $errores = [];
        if (strlen($pass_nueva) < 8) $errores[]="Mínimo 8 caracteres.";
        if (!preg_match('/[a-z]/', $pass_nueva)) $errores[]="Falta minúscula.";
        if (!preg_match('/[A-Z]/', $pass_nueva)) $errores[]="Falta mayúscula.";
        if (!preg_match('/[0-9]/', $pass_nueva)) $errores[]="Falta número.";
        if (!preg_match('/[\W]/', $pass_nueva)) $errores[]="Falta carácter especial (@, #, $).";
        
        #Función verificar_cont para secuencias (si la tienes en funciones.php)
        if (function_exists('verificar_cont') && verificar_cont($pass_nueva)) {
            $errores[]="No uses secuencias (abc, 123).";
        }

        if (!empty($errores)){
            $mensaje=implode("<br>", $errores);
            $tipo_msg="error";
        } else {
            #BUSCAR AL USUARIO EN LAS TABLAS PARA VERIFICAR CONTRASEÑA ACTUAL
            $tablas=[
                'rh'              => 'id_rh', 
                'administradores' => 'id_admin', 
                'doctores'        => 'id_doctor', 
                'usuarios'        => 'id_usuario'
            ];
            
            $usuario_encontrado=false;

            foreach ($tablas as $tabla => $col_id){
                try {
                    $sql="SELECT $col_id as id, contrasena FROM $tabla WHERE usuarios = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$usuario_logueado]);
                    $user_data=$stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user_data) {
                        #Encontramos al usuario, ahora verificamos la contraseña actual
                        if (password_verify($pass_actual, $user_data['contrasena'])) {
                            
                            #CONTRASEÑA CORRECTA, PROCEDEMOS A ACTUALIZAR
                            $nuevo_hash = password_hash($pass_nueva, PASSWORD_DEFAULT);
                            $id_real = $user_data['id'];

                            $sqlUpdate = "UPDATE $tabla SET contrasena = ? WHERE $col_id = ?";
                            $stmtUpdate = $pdo->prepare($sqlUpdate);
                            
                            if ($stmtUpdate->execute([$nuevo_hash, $id_real])) {
                                $mensaje="Contraseña actualizada con éxito";
                                $tipo_msg="success";
                                
                                #Guardar historial si existe la función
                                if (function_exists('registrar_historial')) {
                                    $rol_historial = ($tabla == 'usuarios') ? 'Paciente' : ucfirst($tabla);
                                    registrar_historial($pdo, $usuario_logueado, $rol_historial, 'SEGURIDAD', 'Cambió su contraseña manualmente');
                                }
                            } else {
                                $mensaje = "Error al guardar en la base de datos.";
                                $tipo_msg = "error";
                            }
                            
                            $usuario_encontrado = true;
                            break; #Salimos del foreach

                        } else {
                            $mensaje = "La contraseña actual es incorrecta.";
                            $tipo_msg = "error";
                            $usuario_encontrado = true;# Lo encontramos pero falló la clave
                            break;
                        }
                    }
                } catch (Exception $e) {
                    continue;
                }
            }

            if (!$usuario_encontrado && empty($mensaje)) {
                $mensaje = "Error de sesión: Usuario no encontrado.";
                $tipo_msg = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden m-4">
        
        <div class="bg-gray-800 p-6 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-white">Seguridad de la Cuenta</h1>
                <p class="text-gray-400 text-sm">Cambiar contraseña de acceso</p>
            </div>
            <button onclick="history.back()" class="bg-white/10 hover:bg-white/20 text-white p-2 rounded-full transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-8">
            
            <?php if (!empty($mensaje)): ?>
                <div class="mb-6 p-4 rounded-lg text-sm font-medium text-center <?php echo ($tipo_msg == 'error') ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-green-700 border border-green-200'; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Contraseña Actual</label>
                    <div class="relative">
                        <input type="password" name="pass_actual" required class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm" placeholder="••••••••">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <h4 class="text-blue-800 font-bold text-xs mb-2">REQUISITOS DE SEGURIDAD:</h4>
                    <ul class="text-[11px] text-blue-600 list-disc list-inside space-y-1">
                        <li>Mínimo 8 caracteres</li>
                        <li>Al menos una mayúscula y un número</li>
                        <li>Al menos un carácter especial (@, #, $, etc.)</li>
                        <li>Evitar secuencias (123, abc)</li>
                    </ul>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nueva Contraseña</label>
                        <input type="password" name="pass_nueva" required class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 transition text-sm" placeholder="Nueva clave">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Confirmar Nueva</label>
                        <input type="password" name="pass_confirm" required class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 transition text-sm" placeholder="Repetir clave">
                    </div>
                </div>

                <div class="flex gap-4 pt-2">
                    <button type="button" onclick="history.back()" class="flex-1 py-3 border border-slate-300 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black shadow-lg transition transform hover:-translate-y-0.5">
                        Actualizar
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>