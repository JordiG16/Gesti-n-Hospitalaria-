<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login/login.php");
    exit;
}

include("../../includes/conexiones.php");
include("../../includes/funciones.php");

$mensaje = "";
$tipo_mensaje = "";

#PROCESAR FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificamos si se seleccionó al menos uno
    if (isset($_POST['estudios']) && !empty($_POST['estudios'])) {
        
        $estudios_seleccionados = $_POST['estudios'];
        $id_usuario = $_SESSION['id_usuario'];
        $contador = 0;

        try {
            $pdo->beginTransaction();#Iniciamos transacción para asegurar que se guarden todos
            foreach ($estudios_seleccionados as $estudio){
                #Definimos descripciones automáticas según el tipo
                $descripcion="Análisis clínico estándar.";
                if ($estudio=="Biometría Hemática") $descripcion = "Incluye plaquetas y fórmula roja/blanca.";
                if ($estudio=="Química Sanguínea (6 elementos)") $descripcion = "Glucosa, Urea, Creatinina, Ácido Úrico, Colesterol y Triglicéridos.";
                if ($estudio=="Examen General de Orina") $descripcion = "Análisis físico, químico y microscópico.";
                if ($estudio=="Perfil Lipídico") $descripcion = "Colesterol total, HDL, LDL y Triglicéridos.";
                if ($estudio=="Prueba de Embarazo (Sangre)") $descripcion = "Detección de hormona hCG cualitativa.";

                // Insertamos cada estudio por separado
                $sql="INSERT INTO laboratorio (id_usuario, tipo_estudio, descripcion, fecha_solicitud, estado) VALUES (?, ?, ?, CURDATE(), 'solicitado')";
                $stmt=$pdo->prepare($sql);
                $stmt->execute([$id_usuario, $estudio, $descripcion]);
                $contador++;
            }

            $pdo->commit();#Guardamos cambios

            #Guardamos chisme en historial (solo un registro general)
            registrar_historial($pdo, $_SESSION['usuario_paciente'] ?? 'Paciente', 'Paciente', 'SOLICITUD LAB', "Solicitó $contador estudios de laboratorio.");

            $mensaje="Listo, se han generado $contador ordenes de estudio correctamente.";
            $tipo_mensaje="success";

        } catch (PDOException $e) {
            $pdo->rollBack(); #Si falla algo, deshacemos todo
            $mensaje="Error al procesar la solicitud: " . $e->getMessage();
            $tipo_mensaje="error";
        }

    } else {
        $mensaje="Por favor selecciona al menos un estudio de la lista.";
        $tipo_mensaje="error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Estudios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <?php include (__DIR__ ."/../barra_lateral/side_bar.php"); ?>

    <main class="ml-0 md:ml-80 p-6 md:p-10 transition-all duration-300">
        
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Solicitar Estudios</h1>
        </div>
        <p class="text-slate-500 mb-8 ml-0 md:ml-14">Selecciona los análisis que requieres y genera tu orden digital.</p>

        <?php if (!empty($mensaje)): ?>
            <div class="mb-6 p-4 rounded-xl <?php echo $tipo_mensaje == 'success' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 max-w-4xl">
            
            <form action="" method="POST">
                <div class="space-y-4 grid grid-cols-1 gap-4">
                    
                    <label class="flex items-start p-4 border rounded-xl cursor-pointer hover:bg-purple-50 hover:border-purple-300 transition group">
                        <input type="checkbox" name="estudios[]" value="Biometría Hemática" class="mt-1 w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300">
                        <div class="ml-4">
                            <span class="block font-bold text-slate-800 group-hover:text-purple-700">Biometría Hemática</span>
                            <span class="block text-xs text-slate-500">Incluye plaquetas, hemoglobina y fórmula roja/blanca.</span>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border rounded-xl cursor-pointer hover:bg-purple-50 hover:border-purple-300 transition group">
                        <input type="checkbox" name="estudios[]" value="Química Sanguínea (6 elementos)" class="mt-1 w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300">
                        <div class="ml-4">
                            <span class="block font-bold text-slate-800 group-hover:text-purple-700">Química Sanguínea (6 elementos)</span>
                            <span class="block text-xs text-slate-500">Glucosa, Urea, Creatinina, Ácido Úrico, Colesterol y Triglicéridos.</span>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border rounded-xl cursor-pointer hover:bg-purple-50 hover:border-purple-300 transition group">
                        <input type="checkbox" name="estudios[]" value="Examen General de Orina" class="mt-1 w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300">
                        <div class="ml-4">
                            <span class="block font-bold text-slate-800 group-hover:text-purple-700">Examen General de Orina</span>
                            <span class="block text-xs text-slate-500">Análisis físico, químico y microscópico completo.</span>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border rounded-xl cursor-pointer hover:bg-purple-50 hover:border-purple-300 transition group">
                        <input type="checkbox" name="estudios[]" value="Perfil Lipídico" class="mt-1 w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300">
                        <div class="ml-4">
                            <span class="block font-bold text-slate-800 group-hover:text-purple-700">Perfil Lipídico</span>
                            <span class="block text-xs text-slate-500">Colesterol total, HDL, LDL, VLDL y riesgo aterogénico.</span>
                        </div>
                    </label>

                     <label class="flex items-start p-4 border rounded-xl cursor-pointer hover:bg-purple-50 hover:border-purple-300 transition group">
                        <input type="checkbox" name="estudios[]" value="Prueba de Embarazo (Sangre)" class="mt-1 w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300">
                        <div class="ml-4">
                            <span class="block font-bold text-slate-800 group-hover:text-purple-700">Prueba de Embarazo (Sangre)</span>
                            <span class="block text-xs text-slate-500">Cuantificación de Subunidad Beta hCG.</span>
                        </div>
                    </label>

                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-purple-200 transition transform hover:-translate-y-1">
                        Generar Orden
                    </button>
                </div>
            </form>

        </div>
    </main>
</body>
</html>