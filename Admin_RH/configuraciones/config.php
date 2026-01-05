<?php
session_start();

// 1. SEGURIDAD
if (!isset($_SESSION['usuario']) && !isset($_SESSION['administradores_rh'])) {
    header("Location: ../login/login.php");
    exit();
}

include(__DIR__ . "/../../includes/conexiones.php");

$mensaje = "";
$tipo_msg = "";
$usuario_actual = $_SESSION['usuario'];
$tabla_actual = ""; // Aquí guardaremos si es 'rh' o 'administradores'
$id_columna = "";   // Aquí guardaremos si es 'id_rh' o 'id_admin'

// 2. LÓGICA DE DETECCIÓN DE USUARIO (EL CEREBRO NUEVO 🧠)
// Intentamos buscarlo primero en RH
$sqlRH = "SELECT id_rh as id, nombre, usuarios, contrasena, area FROM rh WHERE usuarios = :usr";
$stmtRH = $pdo->prepare($sqlRH);
$stmtRH->execute([':usr' => $usuario_actual]);
$perfil = $stmtRH->fetch(PDO::FETCH_ASSOC);

if ($perfil) {
    // ¡Es de RH!
    $tabla_actual = "rh";
    $id_columna = "id_rh";
} else {
    // Si no está en RH, buscamos en Administradores
    $sqlAdmin = "SELECT id_admin as id, nombre, usuarios, contrasena FROM administradores WHERE usuarios = :usr";
    $stmtAdmin = $pdo->prepare($sqlAdmin);
    $stmtAdmin->execute([':usr' => $usuario_actual]);
    $perfil = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    if ($perfil) {
        // ¡Es Admin General!
        $tabla_actual = "administradores";
        $id_columna = "id_admin";
        $perfil['area'] = "Administración General"; // Etiqueta visual
    } else {
        // Si no está en ninguno, cerramos sesión por seguridad
        session_destroy();
        die("Error crítico: Usuario no encontrado en ninguna tabla. <a href='../login/login.php'>Volver al Login</a>");
    }
}

// 3. PROCESAR EL GUARDADO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nuevo_nombre  = trim($_POST['nombre']);
    $nuevo_usuario = trim($_POST['correo']); 
    $pass_actual   = $_POST['pass_actual'];
    $pass_nueva    = $_POST['pass_nueva'];

    try {
        $id_usuario = $perfil['id']; // ID Genérico recuperado arriba
        $hash_guardado = $perfil['contrasena'];
        
        // Validar cambio de contraseña
        $actualizar_pass = false;
        
        if (!empty($pass_nueva)) {
            if (password_verify($pass_actual, $hash_guardado)) {
                $actualizar_pass = true;
            } else {
                $mensaje = "La contraseña actual no es correcta.";
                $tipo_msg = "error";
            }
        }

        // Si no hay errores, actualizamos en la tabla correcta
        if (empty($mensaje)) {
            if ($actualizar_pass) {
                $nuevo_hash = password_hash($pass_nueva, PASSWORD_DEFAULT);
                $sqlUpd = "UPDATE $tabla_actual SET nombre = :nom, usuarios = :usu, contrasena = :pass WHERE $id_columna = :id";
                $params = [':nom' => $nuevo_nombre, ':usu' => $nuevo_usuario, ':pass' => $nuevo_hash, ':id' => $id_usuario];
            } else {
                $sqlUpd = "UPDATE $tabla_actual SET nombre = :nom, usuarios = :usu WHERE $id_columna = :id";
                $params = [':nom' => $nuevo_nombre, ':usu' => $nuevo_usuario, ':id' => $id_usuario];
            }

            $stmtUpd = $pdo->prepare($sqlUpd);
            
            if ($stmtUpd->execute($params)) {
                $mensaje = "¡Perfil actualizado correctamente!";
                $tipo_msg = "success";
                
                // Actualizamos sesión y datos visuales en tiempo real
                $_SESSION['usuario'] = $nuevo_usuario;
                $perfil['nombre'] = $nuevo_nombre;
                $perfil['usuarios'] = $nuevo_usuario;
            } else {
                $mensaje = "No se pudieron guardar los cambios.";
                $tipo_msg = "error";
            }
        }

    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
        $tipo_msg = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración | RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-3xl mx-auto p-8">
        
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Configuración</h1>
                <p class="text-sm text-gray-500">Preferencias de tu cuenta.</p>
            </div>
            <a href="../index.php" class="text-gray-400 hover:text-gray-600 text-sm">Cancelar</a>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="mb-6 p-4 rounded-lg <?php echo ($tipo_msg == 'error') ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6">
                <div class="flex items-center gap-3 mb-6 text-blue-600">
                    <h2 class="font-semibold text-gray-900">Información Personal</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nombre</label>
                        <input type="text" name="nombre" 
                               value="<?php echo htmlspecialchars($perfil['nombre'] ?? ''); ?>" 
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Usuario (Login)</label>
                        <input type="text" name="correo" 
                               value="<?php echo htmlspecialchars($perfil['usuarios'] ?? ''); ?>" 
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Área / Rol</label>
                        <input type="text" value="<?php echo htmlspecialchars($perfil['area'] ?? 'N/A'); ?>" disabled
                               class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2 text-gray-500 cursor-not-allowed">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6">
                <div class="flex items-center gap-3 mb-6 text-blue-600">
                    <h2 class="font-semibold text-gray-900">Seguridad</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Contraseña Actual</label>
                        <input type="password" name="pass_actual" placeholder="••••••" 
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nueva Contraseña</label>
                        <input type="password" name="pass_nueva" placeholder="Mínimo 8 caracteres" 
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition">
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>

</body>
</html>