<?php
session_start();

#
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login/login.php");
    exit;
}

include("../../includes/conexiones.php");
include("../../includes/funciones.php");

$mensaje = "";
$tipo_mensaje = "";
$id_usuario = $_SESSION['id_usuario'];

#PROCESAR CANCELACIÓN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_estudio'])) {
    $id_estudio = $_POST['id_estudio'];

    try {
        #Solo permitimos cancelar si el estado es 'solicitado' y pertenece al usuario
        $sql = "UPDATE laboratorio 
                SET estado = 'cancelado', fecha_cancelacion = NOW() 
                WHERE id_estudio = ? AND id_usuario = ? AND estado = 'solicitado'";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_estudio, $id_usuario]);

        if ($stmt->rowCount() > 0) {
            // Guardar en historial
            registrar_historial($pdo, $_SESSION['usuario_paciente'] ?? 'Paciente', 'Paciente', 'CANCELAR LAB', "Canceló la solicitud de estudio ID #$id_estudio");
            
            $mensaje = "La solicitud ha sido cancelada correctamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "No se pudo cancelar. Puede que el estudio ya esté en proceso o no exista.";
            $tipo_mensaje = "error";
        }

    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
        $tipo_mensaje = "error";
    }
}

// 3. CONSULTAR ESTUDIOS PENDIENTES (Solo los 'solicitado')
$estudios = [];
try {
    $sql = "SELECT * FROM laboratorio 
            WHERE id_usuario = ? AND estado = 'solicitado' 
            ORDER BY fecha_solicitud DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario]);
    $estudios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejo silencioso o log
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cancelar Laboratorio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <?php include (__DIR__ ."/../barra_lateral/side_bar.php"); ?>

    <main class="ml-0 md:ml-80 p-6 md:p-10 transition-all duration-300">
        
        <div class="flex items-center gap-3 mb-6">
            <h1 class="text-3xl font-bold text-slate-900">Cancelar Solicitud de Estudios</h1>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 max-w-4xl mb-8 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Solo puedes cancelar estudios que aún permanecen como <span class="font-bold">"Solicitado"</span>. 
                        Si el laboratorio ya comenzó el proceso, deberás contactarlos directamente.
                    </p>
                </div>
            </div>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="mb-6 p-4 rounded-xl max-w-4xl <?php echo $tipo_mensaje == 'success' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <?php if (count($estudios) > 0): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-4xl">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b border-slate-100">
                        <tr>
                            <th class="p-5">Fecha Solicitud</th>
                            <th class="p-5">Estudio</th>
                            <th class="p-5 hidden sm:table-cell">Descripción</th>
                            <th class="p-5 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <?php foreach ($estudios as $row): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-5 font-bold text-slate-700">
                                    <?php echo date("d/m/Y", strtotime($row['fecha_solicitud'])); ?>
                                </td>
                                <td class="p-5">
                                    <span class="block text-slate-800 font-semibold"><?php echo htmlspecialchars($row['tipo_estudio']); ?></span>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-purple-100 text-purple-700">
                                        <?php echo $row['estado']; ?>
                                    </span>
                                </td>
                                <td class="p-5 text-slate-500 hidden sm:table-cell">
                                    <?php echo htmlspecialchars($row['descripcion']); ?>
                                </td>
                                <td class="p-5 text-right">
                                    <form method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar esta solicitud?');">
                                        <input type="hidden" name="id_estudio" value="<?php echo $row['id_estudio']; ?>">
                                        <button type="submit" name="btn_cancelar" class="bg-white border border-red-200 text-red-500 hover:bg-red-50 hover:text-red-700 font-bold py-2 px-4 rounded-lg transition text-xs shadow-sm">
                                            Cancelar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="bg-white p-12 rounded-2xl border border-dashed border-slate-300 text-center max-w-4xl">
                <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-slate-400 italic text-lg">No tienes solicitudes pendientes por cancelar.</p>
                <a href="solicitar.php" class="text-purple-600 font-bold hover:underline text-sm mt-2 block">Solicitar nuevos estudios &rarr;</a>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>