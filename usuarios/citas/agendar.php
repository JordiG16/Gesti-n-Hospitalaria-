<?php
session_start();


#CONEXIONES Y FUNCIONES
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login/login.php");
    exit;
}
#Ruta
include(__DIR__ ."/../../includes/conexiones.php"); 
include(__DIR__ ."/../../includes/funciones.php"); // Para usar registrar_historial()

$mensaje = "";
$tipo_mensaje = "";

#logica
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $id_usuario = $_SESSION['id_usuario'];     


    $especialidad=$_POST['especialidad'];
    $id_doctor=!empty($_POST['id_doctor']) ? $_POST['id_doctor'] : NULL;
    $fecha=$_POST['fecha'];
    $hora=$_POST['hora'];
    $motivo=$_POST['motivo'];

    #validaciones
    if (empty($especialidad) || empty($fecha) || empty($hora) || empty($motivo)) {
        $mensaje="Por favor completa todos los campos obligatorios.";
        $tipo_mensaje="error";
    } else {
        try {
            
            $sql="INSERT INTO citas (id_usuario, id_doctor, especialidad, fecha_cita, hora_cita, motivo_consulta, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, 'pendiente')";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$id_usuario, $id_doctor, $especialidad, $fecha, $hora, $motivo]);


            if (function_exists('registrar_historial')) {
                registrar_historial($pdo, $_SESSION['usuario_paciente'] ?? 'Paciente', 'Paciente', 'AGENDAR', "Agendó cita de $especialidad para el $fecha");
            }

            $mensaje="¡Cita agendada con éxito! Tu solicitud está pendiente.";
            $tipo_mensaje="success";

        } catch (PDOException $e) {
            $mensaje="Error al agendar: " . $e->getMessage();
            $tipo_mensaje="error";
        }
    }
}

// 3. CONSULTAR DOCTORES PARA EL SELECT (DINÁMICO)
$doctores=[];
try {
    $stmtDocs=$pdo->query("SELECT id_doctor, nombre, especialidad FROM doctores");
    $doctores=$stmtDocs->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Si falla, no pasa nada, el select saldrá vacío
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agendar Cita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <?php include (__DIR__."/../barra_lateral/side_bar.php"); ?>

    <main class="ml-0 md:ml-80 p-6 md:p-10 transition-all duration-300">
        
        <h1 class="text-3xl font-bold text-sky-900 mb-2">Agendar Nueva Cita</h1>
        <p class="text-slate-500 mb-8">Selecciona la especialidad y el horario de tu preferencia.</p>

        <?php if (!empty($mensaje)): ?>
            <div class="mb-6 p-4 rounded-xl <?php echo $tipo_mensaje == 'success' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 max-w-4xl">
            <form action="" method="POST" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Especialidad Médica </label>
                        <select name="especialidad" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-sky-500 transition">
                            <option value="">Selecciona...</option>
                            <option value="Medicina General">Medicina General</option>
                            <option value="Cardiología">Cardiología</option>
                            <option value="Pediatría">Pediatría</option>
                            <option value="Ginecología">Ginecología</option>
                            <option value="Nutrición">Nutrición</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Doctor Preferido (Opcional)</label>
                        <select name="id_doctor" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-sky-500 transition">
                            <option value="">Cualquiera disponible</option>
                            <?php foreach ($doctores as $doc): ?>
                                <option value="<?php echo $doc['id_doctor']; ?>">
                                    <?php echo $doc['nombre'] . " (" . $doc['especialidad'] . ")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Fecha Deseada *</label>
                        <input type="date" name="fecha" required min="<?php echo date('Y-m-d'); ?>" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Horario *</label>
                        <input type="time" name="hora" required min="08:00" max="20:00"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-sky-500 transition">
                        <p class="text-xs text-slate-400 mt-1">Horario de atención: 08:00 AM - 08:00 PM</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Motivo de la consulta *</label>
                    <textarea name="motivo" rows="3" required placeholder="Describe brevemente tus síntomas..." 
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-sky-500 transition"></textarea>
                </div>
                
                <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-sky-200 transition transform hover:-translate-y-1">
                    Confirmar Cita
                </button>
            </form>
        </div>
    </main>
</body>
</html>