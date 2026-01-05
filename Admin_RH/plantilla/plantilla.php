<?php
session_start();

#SEGURIDAD
if (!isset($_SESSION['usuario']) && !isset($_SESSION['administradores_rh'])) {
    header("Location: ../login/login.php");
    exit();
}

#CONEXIÓN
include(__DIR__ . "/../../includes/conexiones.php");

#LOGICA DE BÚSQUEDA
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

try {
    #CONSULTAR DOCTORES
    $sqlDocs="SELECT id_doctor as id, nombre, especialidad as rol, 'doctor' as tipo 
                FROM doctores 
                WHERE nombre LIKE :b OR especialidad LIKE :b";
    
    $stmtDocs=$pdo->prepare($sqlDocs);
    $stmtDocs->execute([':b' => "%$busqueda%"]);
    $lista_docs=$stmtDocs->fetchAll(PDO::FETCH_ASSOC);

    #CONSULTAR ADMINISTRADORES
    
    $sqlAdmins="SELECT id_admin as id, nombre, 'Administrativo' as rol, 'admin' as tipo 
                  FROM administradores 
                  WHERE nombre LIKE :b";

    $stmtAdmins = $pdo->prepare($sqlAdmins);
    $stmtAdmins->execute([':b' => "%$busqueda%"]);
    $lista_admins = $stmtAdmins->fetchAll(PDO::FETCH_ASSOC);

    #UNIR AMBAS LISTAS
    #Juntamos doctores y admins en una sola variable $personal
    $personal = array_merge($lista_docs, $lista_admins);

} catch (PDOException $e) {
    die("Error al cargar personal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plantilla | RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-7xl mx-auto p-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Plantilla de Personal</h1>
                <p class="text-sm text-gray-500">Directorio activo de médicos y administrativos.</p>
            </div>
            
            <div class="flex gap-3 items-center">
                <form action="" method="GET" class="flex gap-2">
                    <input type="text" 
                           name="q" 
                           value="<?php echo htmlspecialchars($busqueda); ?>"
                           placeholder="Buscar empleado..." 
                           class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    
                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700">
                    </button>
                    
                    <?php if($busqueda): ?>
                        <a href="plantilla.php" class="text-red-500 text-sm hover:underline self-center">Limpiar</a>
                    <?php endif; ?>
                </form>

                <a href="../index.php" class="text-gray-500 hover:text-gray-700 self-center text-sm ml-4">&larr; Volver</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <?php if (empty($personal)): ?>
                <div class="col-span-3 text-center py-10 text-gray-400">
                    No se encontraron empleados con ese nombre.
                </div>
            <?php else: ?>

                <?php foreach ($personal as $empleado): ?>
                    <?php 
                        #Configuración Visual según el TIPO (Doctor vs Admin)
                        if ($empleado['tipo'] === 'doctor') {
                            $bg_avatar = 'bg-blue-100 text-blue-600';
                            $text_rol  = 'text-blue-600';
                            $prefijo   = 'DOC-';
                            $icono     = 'Dr.'; // Opcional, solo visual
                        } else {
                            $bg_avatar = 'bg-green-100 text-green-600';
                            $text_rol  = 'text-green-600';
                            $prefijo   = 'ADM-';
                            $icono     = 'Lic.'; // Opcional
                        }

                        // 2. Generar Iniciales (Ej: Juan Perez -> JP)
                        $partes_nombre = explode(" ", $empleado['nombre']);
                        $iniciales = strtoupper(substr($partes_nombre[0], 0, 1));
                        if (isset($partes_nombre[1])) {
                            $iniciales .= strtoupper(substr($partes_nombre[1], 0, 1));
                        }
                    ?>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-md transition">
                        
                        <div class="w-12 h-12 rounded-full <?php echo $bg_avatar; ?> flex items-center justify-center font-bold text-lg flex-shrink-0">
                            <?php echo $iniciales; ?>
                        </div>
                        
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-bold text-gray-900 truncate" title="<?php echo htmlspecialchars($empleado['nombre']); ?>">
                                <?php echo htmlspecialchars($empleado['nombre']); ?>
                            </h3>
                            
                            <p class="text-xs <?php echo $text_rol; ?> font-semibold mb-1 uppercase">
                                <?php echo htmlspecialchars($empleado['rol']); ?>
                            </p>
                            
                            <p class="text-xs text-gray-500">
                                Estado: <span class="text-green-500">Activo</span>
                            </p>
                            
                            <p class="text-xs text-gray-400 mt-2 font-mono">
                                ID: <?php echo $prefijo . str_pad($empleado['id'], 3, '0', STR_PAD_LEFT); ?>
                            </p>
                        </div>
                        
                        
                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>
</body>
</html>