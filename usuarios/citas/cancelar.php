<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login/login.php");
    exit;
}

include("../../includes/conexiones.php");
include("../../includes/funciones.php");

$mensaje = "";
$id_usuario = $_SESSION['id_usuario'];

#PROCESAR CANCELACIÓN (CUANDO LE DAS CLICK AL BOTÓN ROJO) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_cancelar'])) {
    $id_cita_cancelar = $_POST['id_cita'];
    $motivo = "Cancelado por el usuario desde el portal web."; // Motivo automático o podrías poner un input

    try {
        #Actualizamos estado y agregamos la auditoría (fecha y motivo)
        $sql="UPDATE citas SET estado='cancelada', fecha_cancelacion = NOW(), cancelado_por = 'paciente', motivo_cancelacion = ?
                WHERE id_cita = ? AND id_usuario = ?"; // El AND id_usuario es vital para que no cancelen citas de otros
        
        $stmt=$pdo->prepare($sql);
        $res=$stmt->execute([$motivo, $id_cita_cancelar, $id_usuario]);

        if ($stmt->rowCount() > 0) {
            #Guardamos el rollo en historial
            registrar_historial($pdo, $_SESSION['usuario_paciente'] ?? 'Paciente', 'Paciente', 'CANCELAR', "Canceló la cita ID #$id_cita_cancelar");
            
            $mensaje="La cita ha sido cancelada correctamente.";
        } else {
            $mensaje="Error: No se pudo cancelar la cita o ya estaba cancelada.";
        }

    } catch (PDOException $e) {
        $mensaje = "Error técnico: " . $e->getMessage();
    }
}

// --- 2. CONSULTAR CITAS ACTIVAS (PARA MOSTRAR EN LA LISTA) ---
// Solo traemos pendientes o confirmadas que sean futuras (o de hoy en adelante)
$sql_activas = "SELECT * FROM citas 
                WHERE id_usuario = ? 
                AND estado IN ('pendiente', 'confirmada') 
                AND fecha_cita >= CURDATE()
                ORDER BY fecha_cita ASC";
$stmt = $pdo->prepare($sql_activas);
$stmt->execute([$id_usuario]);
$citas_activas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cancelar Cita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <?php include '../barra_lateral/side_bar.php'; ?>

    <main class="ml-0 md:ml-80 p-6 md:p-10 transition-all duration-300">
        
        <h1 class="text-3xl font-bold text-red-600 mb-2">Cancelar Citas</h1>
        <p class="text-slate-500 mb-8">Aquí puedes cancelar tus citas próximas. Esta acción no se puede deshacer.</p>

        <?php if (!empty($mensaje)): ?>
            <div class="bg-slate-800 text-white p-4 rounded-xl mb-6 flex items-center gap-3 shadow-lg">
                <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <?php if (count($citas_activas) > 0): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold">
                        <tr>
                            <th class="p-5">Fecha</th>
                            <th class="p-5">Especialidad</th>
                            <th class="p-5">Estado Actual</th>
                            <th class="p-5 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <?php foreach ($citas_activas as $cita): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-5 font-bold text-slate-700">
                                    <?php echo date("d/m/Y", strtotime($cita['fecha_cita'])); ?> <br>
                                    <span class="text-xs font-normal text-slate-400"><?php echo date("g:i A", strtotime($cita['hora_cita'])); ?></span>
                                </td>
                                <td class="p-5 text-slate-600"><?php echo htmlspecialchars($cita['especialidad']); ?></td>
                                <td class="p-5">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase 
                                        <?php echo $cita['estado']=='confirmada' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                        <?php echo $cita['estado']; ?>
                                    </span>
                                </td>
                                <td class="p-5 text-right">
                                    <form method="POST" onsubmit="return confirm('¿Estás SEGURO de que quieres cancelar esta cita?');">
                                        <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                                        <button type="submit" name="btn_cancelar" class="bg-white border border-red-200 text-red-500 hover:bg-red-50 hover:text-red-700 font-bold py-2 px-4 rounded-lg transition text-xs shadow-sm">
                                            Cancelar Cita
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="bg-white p-10 rounded-2xl border border-dashed border-slate-300 text-center">
                <p class="text-slate-400">No tienes citas próximas para cancelar.</p>
                <a href="mis_citas.php" class="text-sky-600 text-sm hover:underline mt-2 block">Ver historial completo &rarr;</a>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>