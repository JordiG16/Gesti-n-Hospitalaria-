<?php
session_start();
$ruta = ".."; 

#SEGURIDAD
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login/login.php");
    exit;
}

include("../../includes/conexiones.php");

$id_usuario = $_SESSION['id_usuario'];
$mensaje = "";
$tipo_mensaje = "";

#ACTUALIZAR DATOS (CUANDO LE DAS A GUARDAR)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_correo = $_POST['correo'];
    $nuevo_telefono = $_POST['telefono'];
    $nueva_direccion = $_POST['direccion'];

    if (!empty($nuevo_correo) && !empty($nuevo_telefono)) {
        try {
            $sql="UPDATE usuarios SET correo=?, telefono=?, direccion = ? WHERE id_usuario = ?";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$nuevo_correo, $nuevo_telefono, $nueva_direccion, $id_usuario]);

            $mensaje="Datos actualizados correctamente";
            $tipo_mensaje="success";
        } catch (PDOException $e) {
            $mensaje = "Error al actualizar: " . $e->getMessage();
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje="El correo y teléfono no pueden estar vacíos.";
        $tipo_mensaje = "error";
    }
}

#OBTENER DATOS DEL USUARIO (PARA MOSTRARLOS EN EL FORMULARIO)
#Esto debe ir DESPUÉS del update para que muestre los datos nuevos si acabas de guardar
try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $datos_usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error de conexión";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <?php include (__DIR__ ."/../barra_lateral/side_bar.php"); ?>

    <main class="ml-0 md:ml-80 p-6 md:p-10 transition-all duration-300">
        
        <h1 class="text-3xl font-bold text-slate-900 mb-8">Mi Información Personal</h1>
        
        <?php if (!empty($mensaje)): ?>
            <div class="mb-6 p-4 rounded-xl max-w-4xl <?php echo $tipo_mensaje == 'success' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 max-w-4xl overflow-hidden">
            
            <div class="bg-slate-50 p-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                     <div class="w-16 h-16 rounded-full bg-cyan-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-cyan-200">
                        <?php echo strtoupper(substr($datos_usuario['nombre'] ?? 'U', 0, 1)); ?>
                    </div>
                    <div>
                        <h2 class="font-bold text-xl text-slate-800"><?php echo htmlspecialchars($datos_usuario['nombre']); ?></h2>
                        <p class="text-slate-500 text-sm">Paciente Afiliado • ID: <?php echo str_pad($id_usuario, 4, '0', STR_PAD_LEFT); ?></p>
                    </div>
                </div>
                <button type="button" class="text-cyan-600 font-bold text-sm hover:underline cursor-not-allowed opacity-50" title="Próximamente">Editar Foto</button>
            </div>
            
            <form method="POST" action="" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Nombre Completo (No editable)</label>
                    <input type="text" value="<?php echo htmlspecialchars($datos_usuario['nombre']); ?>" class="w-full border border-slate-200 rounded-lg p-3 text-sm bg-slate-100 text-slate-500 cursor-not-allowed" readonly>
                    <p class="text-[10px] text-slate-400 mt-1">Para corregir tu nombre, contacta a administración.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Usuario de Acceso</label>
                    <input type="text" value="<?php echo htmlspecialchars($datos_usuario['usuarios']); ?>" class="w-full border border-slate-200 rounded-lg p-3 text-sm bg-slate-100 text-slate-500" readonly>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">CURP</label>
                    <input type="text" value="<?php echo htmlspecialchars($datos_usuario['curp'] ?? 'NO REGISTRADO'); ?>" class="w-full border border-slate-200 rounded-lg p-3 text-sm bg-slate-100 text-slate-500" readonly>
                </div>

                <div class="col-span-1 md:col-span-2 my-2 border-t border-slate-100 pt-4">
                    <p class="text-sm font-bold text-cyan-700 mb-4">Información de Contacto (Editable)</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Correo Electrónico</label>
                    <input type="email" name="correo" value="<?php echo htmlspecialchars($datos_usuario['correo']); ?>" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-cyan-500 outline-none transition" required>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Teléfono</label>
                    <input type="tel" name="telefono" value="<?php echo htmlspecialchars($datos_usuario['telefono']); ?>" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-cyan-500 outline-none transition" required>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Dirección</label>
                    <input type="text" name="direccion" value="<?php echo htmlspecialchars($datos_usuario['direccion'] ?? ''); ?>" class="w-full border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-cyan-500 outline-none transition" placeholder="Calle, Número, Colonia...">
                </div>

                <div class="col-span-1 md:col-span-2 text-right mt-4">
                    <button type="submit" class="bg-cyan-600 text-white px-8 py-3 rounded-xl font-bold shadow-md hover:bg-cyan-700 transition transform hover:-translate-y-0.5">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>