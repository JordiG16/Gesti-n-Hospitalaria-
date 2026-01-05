<?php
session_start();

#SEGURIDAD
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login/login.php");
    exit;
}

include("../../includes/conexiones.php");

$id_usuario=$_SESSION['id_usuario'];
$resultados=[];

try {
    #Traemos los estudios ordenados: Primero los COMPLETADOS, luego los EN PROCESO, al final los SOLICITADOS
    #Y dentro de eso, por fecha más reciente.
    $sql="SELECT * FROM laboratorio 
            WHERE id_usuario = ? 
            ORDER BY 
            CASE 
                WHEN estado = 'completado' THEN 1
                WHEN estado = 'en_proceso' THEN 2
                WHEN estado = 'solicitado' THEN 3
                ELSE 4
            END, 
            fecha_solicitud DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Laboratorio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <?php include (__DIR__ ."/../barra_lateral/side_bar.php"); ?>

    <main class="ml-0 md:ml-80 p-6 md:p-10 transition-all duration-300">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Resultados Disponibles</h1>
                <p class="text-slate-500 mt-1">Consulta y descarga tus informes médicos.</p>
            </div>
            <a href="solicitar.php" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-bold shadow-md transition text-sm">
                + Nuevo Estudio
            </a>
        </div>
        
        <?php if (count($resultados) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl">
                
                <?php foreach ($resultados as $row): ?>
                    <?php 
                        #logica de diseño según Estado
                        $icono_color="bg-gray-100 text-gray-500";
                        $texto_estado="Desconocido";
                        $puede_descargar=false;

                        if ($row['estado']=='completado') {
                            $icono_color="bg-green-100 text-green-600";
                            $texto_estado="Listo para descargar";
                            $puede_descargar=true;
                        } elseif ($row['estado']=='en_proceso') {
                            $icono_color="bg-blue-100 text-blue-600";
                            $texto_estado="En análisis...";
                        } elseif ($row['estado']=='solicitado') {
                            $icono_color="bg-yellow-100 text-yellow-600";
                            $texto_estado="Solicitud recibida";
                        } elseif ($row['estado']=='cancelado') {
                            $icono_color="bg-red-100 text-red-600";
                            $texto_estado="Cancelado";
                        }
                        
                        #Fecha bonita
                        $fecha = date("d M, Y", strtotime($row['fecha_solicitud']));
                    ?>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between h-full">
                        
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 rounded-xl <?php echo $icono_color; ?>">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide"><?php echo $fecha; ?></span>
                            </div>

                            <h3 class="font-bold text-lg text-slate-800 mb-1 leading-tight">
                                <?php echo htmlspecialchars($row['tipo_estudio']); ?>
                            </h3>
                            <p class="text-sm text-slate-500 mb-4 line-clamp-2">
                                <?php echo htmlspecialchars($row['descripcion']); ?>
                            </p>
                            
                            <div class="mb-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $icono_color; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $row['estado'])); ?>
                                </span>
                            </div>
                        </div>

                        <?php if ($puede_descargar && !empty($row['archivo_resultado'])): ?>
                            <a href="../../uploads/<?php echo $row['archivo_resultado']; ?>" download target="_blank" 
                               class="w-full py-2.5 border border-cyan-200 bg-cyan-50 text-cyan-700 rounded-xl hover:bg-cyan-100 font-bold text-sm flex items-center justify-center gap-2 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Descargar PDF
                            </a>
                        <?php elseif ($row['estado'] == 'cancelado'): ?>
                            <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 rounded-xl font-bold text-sm cursor-not-allowed">
                                No disponible
                            </button>
                        <?php else: ?>
                            <button disabled class="w-full py-2.5 border border-slate-100 text-slate-400 rounded-xl font-medium text-sm flex items-center justify-center gap-2 cursor-wait">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Procesando...
                            </button>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>

            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                <h3 class="text-lg font-medium text-slate-900">Aún no tienes resultados</h3>
                <p class="text-slate-500 mb-6">Cuando tus análisis estén listos, aparecerán aquí.</p>
                <a href="solicitar.php" class="text-purple-600 font-bold hover:underline">Solicitar estudios &rarr;</a>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>