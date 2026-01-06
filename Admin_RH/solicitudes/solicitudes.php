<?php
session_start();

#SEGURIDAD: Verificamos si hay sesión iniciada (si no, lo mandamos al login)
if (!isset($_SESSION['usuario']) && !isset($_SESSION['administradores_rh'])) {
    header("Location: ../../login/login.php");
    exit();
}

include ( __DIR__ . "/../../includes/conexiones.php");

#CONSULTA: Traemos todas las solicitudes ordenadas por fecha
try {
    $sql = "SELECT * FROM solicitudes_empleo ORDER BY fecha_solicitud DESC";
    $stmt = $pdo->query($sql);
    $solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes | RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="max-w-7xl mx-auto p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Solicitudes de Ingreso</h1>
                <p class="text-sm text-gray-500">Gestión de postulantes y nuevas contrataciones.</p>
            </div>
            <a href="../index.php" class="text-blue-600 hover:underline text-sm font-medium">&larr; Volver al Panel</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b">
                        <th class="p-4 font-semibold">Candidato</th>
                        <th class="p-4 font-semibold">Puesto Solicitado</th>
                        <th class="p-4 font-semibold">Fecha</th>
                        <th class="p-4 font-semibold">Estado</th>
                        <th class="p-4 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    
                    <?php if (empty($solicitudes)): ?>
                        <tr><td colspan="5" class="p-8 text-center text-gray-400">No hay solicitudes pendientes.</td></tr>
                    <?php else: ?>
                        
                        <?php foreach ($solicitudes as $sol): ?>
                            <?php 
                                $estado_db = strtolower($sol['estado']); 
                                $badgeColor = match($estado_db){
                                    'pendiente'  => 'bg-yellow-100 text-yellow-700',
                                    'aceptado'   => 'bg-green-100 text-green-700',
                                    'rechazado'  => 'bg-red-100 text-red-700',
                                    'entrevista' => 'bg-blue-100 text-blue-700',
                                    default      => 'bg-gray-100 text-gray-600'
                                };
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-medium text-gray-900"><?= htmlspecialchars($sol['nombre_candidato']); ?></td>
                                <td class="p-4 text-gray-600"><?= htmlspecialchars($sol['puesto_interes']); ?></td>
                                <td class="p-4 text-gray-500"><?= date("d M Y", strtotime($sol['fecha_solicitud'])); ?></td>
                                <td class="p-4"><span class="<?= $badgeColor; ?> px-2 py-1 rounded-full text-xs font-bold"><?= ucfirst($estado_db); ?></span></td>
                                
                                <td class="p-4 text-right space-x-2">
                                    <?php if (!empty($sol['archivo_cv'])): ?>
                                        <a href=""<?= htmlspecialchars($sol['archivo_cv']); ?> target="_blank" class="text-blue-600 hover:text-blue-800 font-medium text-xs border border-blue-200 px-2 py-1 rounded hover:bg-blue-50">Ver CV</a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs cursor-not-allowed px-2 py-1">Sin CV</span>
                                    <?php endif; ?>

                                    <?php if ($estado_db === 'pendiente'): ?>
                                        
                                        <a href="acciones_rh.php?id=<?= $sol['id_solicitud'] ?>&accion=aceptar" 
                                           class="text-green-600 hover:text-green-800 font-medium text-xs border border-green-200 px-2 py-1 rounded hover:bg-green-50">
                                            Aceptar
                                        </a>

                                        <a href="acciones_rh.php?id=<?= $sol['id_solicitud'] ?>&accion=rechazar" 
                                           class="text-red-600 hover:text-red-800 font-medium text-xs border border-red-200 px-2 py-1 rounded hover:bg-red-50"
                                           onclick="return confirm('¿Seguro?');">
                                            Rechazar
                                        </a>

                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs italic">Procesado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</body>
</html>