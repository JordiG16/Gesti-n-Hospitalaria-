<?php
session_start();

if (!isset($_SESSION['usuario']) && !isset($_SESSION['administradores_rh'])) {

    header("Location: ../login/login.php");
    exit();
}


include(__DIR__ . "/../../includes/conexiones.php");


try {
    $sql = "SELECT * FROM historial_logs ORDER BY fecha DESC";
    $stmt = $pdo->query($sql);
    $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar el historial: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial | RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-4xl mx-auto p-8">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Registro de Actividades</h1>
            <a href="../index.php" class="text-blue-600 hover:underline text-sm font-medium">&larr; Volver</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <ul class="space-y-6">
                
                <?php if (empty($historial)): ?>
                    <li class="text-center text-gray-400 py-4">No hay actividad registrada en el sistema.</li>
                <?php else: ?>

                    <?php foreach ($historial as $log): ?>
                        <?php 
                     
                            $accion = strtoupper($log['accion']); // Convertimos a mayúsculas para comparar fácil
                            
                            if (str_contains($accion, 'ELIMINAR') || str_contains($accion, 'CANCELAR') || str_contains($accion, 'RECHAZAR')) {
                                $colorDot = 'bg-red-400'; // Rojo para cosas destructivas o negativas
                            } elseif (str_contains($accion, 'AGENDAR') || str_contains($accion, 'REGISTRO') || str_contains($accion, 'ACEPTAR') || str_contains($accion, 'SOLICITUD')) {
                                $colorDot = 'bg-green-500'; // Verde para cosas positivas o creaciones
                            } else {
                                $colorDot = 'bg-blue-500'; // Azul para info, inventario, editar, entrevista, etc.
                            }
                            
                            // Formateamos la fecha (Ej: 05 Ene, 02:00 PM)
                            $fecha_fmt = date("d M, h:i A", strtotime($log['fecha']));
                        ?>

                        <li class="relative flex gap-6 items-start">
                            <div class="absolute left-0 top-0 mt-1.5 ml-1.5 w-0.5 h-full bg-gray-100 -z-10"></div>
                            
                            <div class="absolute left-0 top-0 mt-1.5 -ml-1.5 w-3 h-3 <?php echo $colorDot; ?> rounded-full border-2 border-white shadow-sm"></div>
                            
                            <div class="flex-1 pl-6 pb-4">
                                <p class="text-xs text-gray-400 font-mono mb-1"><?php echo $fecha_fmt; ?></p>
                                
                                <p class="text-sm text-gray-800 font-medium">
                                    <?php echo htmlspecialchars($log['usuario']); ?> 
                                    <span class="text-xs text-gray-500 font-normal">
                                        (<?php echo htmlspecialchars($log['rol']); ?>)
                                    </span>
                                </p>
                                
                                <p class="text-sm text-gray-600 mt-0.5">
                                    <span class="font-semibold text-gray-700"><?php echo htmlspecialchars($log['accion']); ?>:</span>
                                    <?php echo htmlspecialchars($log['descripcion']); ?>
                                </p>
                            </div>
                        </li>

                    <?php endforeach; ?>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</body>
</html>