<?php
session_start();

#CONFIGURACIÓN
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../login/login.php");
    exit;
}

include("../../includes/conexiones.php");

// 3. OBTENER LAS CITAS DE LA BASE DE DATOS
$id_usuario=$_SESSION['id_usuario'];
$citas=[];

try {
    #Traemos los datos de la cita y el nombre del doctor (JOIN)
    #Usamos LEFT JOIN por si el doctor aún no está asignado (es NULL)
    $sql="SELECT c.*, d.nombre as nombre_doctor 
            FROM citas c 
            LEFT JOIN doctores d ON c.id_doctor=d.id_doctor 
            WHERE c.id_usuario=? 
            ORDER BY c.fecha_cita DESC, c.hora_cita ASC";
            
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$id_usuario]);
    $citas=$stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error="Error al cargar citas: " . $e->getMessage();
}

#Array para traducir meses al español rápido
$meses=['01'=>'ENE', '02'=>'FEB', '03'=>'MAR', '04'=>'ABR', '05'=>'MAY', '06'=>'JUN','07'=>'JUL', '08'=>'AGO', '09'=>'SEP', '10'=>'OCT', '11'=>'NOV', '12'=>'DIC'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Citas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <?php include (__DIR__ ."/../barra_lateral/side_bar.php"); ?>

    <main class="ml-0 md:ml-80 p-6 md:p-10 transition-all duration-300">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-cyan-900">Mis Citas Programadas</h1>
            <a href="agendar.php" class="bg-cyan-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-cyan-700 transition shadow-md">
                + Nueva
            </a>
        </div>

        <?php if (count($citas) > 0): ?>
            <div class="grid gap-4 max-w-4xl">
                
                <?php foreach ($citas as $cita): ?>
                    <?php
                        #Preparar datos visuales
                        $fechaObj=new DateTime($cita['fecha_cita']);
                        $dia=$fechaObj->format('d');
                        $numMes=$fechaObj->format('m');
                        $mesTexto=$meses[$numMes];
                        $horaFormato=date("g:i A", strtotime($cita['hora_cita']));

                        #Lógica de colores según estado
                        $bordeColor="bg-gray-400"; // Por defecto
                        $badgeColor="bg-gray-100 text-gray-600";
                        
                        if ($cita['estado']=='confirmada'){
                            $bordeColor="bg-green-500";
                            $badgeColor="bg-green-100 text-green-700";
                        } elseif ($cita['estado']=='pendiente'){
                            $bordeColor="bg-yellow-400";
                            $badgeColor="bg-yellow-100 text-yellow-700";
                        } elseif ($cita['estado']=='cancelada'){
                            $bordeColor="bg-red-500";
                            $badgeColor="bg-red-100 text-red-700";
                        } elseif ($cita['estado']=='realizada'){
                            $bordeColor="bg-blue-500";
                            $badgeColor="bg-blue-100 text-blue-700";
                        }
                    ?>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex justify-between items-center relative overflow-hidden group hover:shadow-md transition">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-2 <?php echo $bordeColor; ?>"></div>
                        
                        <div class="pl-4 flex items-center gap-6">
                            <div class="text-center min-w-[60px]">
                                <p class="text-sm font-bold text-slate-400 uppercase"><?php echo $mesTexto; ?></p>
                                <p class="text-3xl font-bold text-slate-800"><?php echo $dia; ?></p>
                            </div>
                            
                            <div>
                                <h3 class="font-bold text-lg text-slate-800"><?php echo htmlspecialchars($cita['especialidad']); ?></h3>
                                <p class="text-slate-500 text-sm">
                                    <?php echo $cita['nombre_doctor'] ? "Dr. ".$cita['nombre_doctor'] : "Doctor por asignar"; ?> 
                                    • <?php echo $horaFormato; ?>
                                </p>
                                <span class="inline-block mt-2 px-3 py-1 text-xs font-bold rounded-full uppercase <?php echo $badgeColor; ?>">
                                    <?php echo $cita['estado']; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                             <?php if ($cita['estado'] != 'cancelada' && $cita['estado'] != 'realizada'): ?>
                                <a href="cancelar.php" class="px-4 py-2 border border-red-200 text-red-500 rounded-lg hover:bg-red-50 font-medium text-sm text-center">
                                    Cancelar
                                </a>
                             <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        
        <?php else: ?>
            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <h3 class="text-lg font-medium text-slate-900">No tienes citas programadas</h3>
                <p class="text-slate-500 mb-6">¿Necesitas ver a un médico?</p>
                <a href="agendar.php" class="text-cyan-600 font-bold hover:underline">Agendar una cita ahora &rarr;</a>
            </div>
        <?php endif; ?>

    </main>
</body>
</html>