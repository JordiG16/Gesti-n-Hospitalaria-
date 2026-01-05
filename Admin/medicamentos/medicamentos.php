<?php
session_start();
include("../../includes/conexiones.php");

#BTENER MEDICAMENTOS
$medicamentos=[];
try {
    $sql="SELECT * FROM medicamentos ORDER BY principio_activo ASC";
    $stmt=$pdo->query($sql);
    $medicamentos=$stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

#CALCULAR INDICADORES (KPIs)
$total_meds=count($medicamentos);
$criticos=0; 
$total_unidades=0;

foreach ($medicamentos as $med) {
    $total_unidades+=$med['cantidad_stock'];#Sumamos todo el inventario
    if ($med['cantidad_stock'] < 15) {
        $criticos++;#Contamos los que están bajos
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Farmacia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex">

    <main class="flex-1 p-6 md:p-10 ml-0 md:ml-72 transition-all">

        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Farmacia e Inventario</h1>
                <p class="text-slate-500 mt-1">Gestión y control de stock de medicamentos.</p>
            </div>
            <a href="./medicamentos_back/agregar_medicamento.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition flex items-center gap-2 text-sm font-bold transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Ingreso
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-indigo-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-indigo-400 uppercase tracking-wider">Catálogo Activo</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1"><?= $total_meds ?></p>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-red-400 uppercase tracking-wider">Stock Crítico</p>
                    <p class="text-3xl font-bold text-red-600 mt-1"><?= $criticos ?></p>
                </div>
                <div class="p-3 bg-red-50 text-red-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Unidades en Almacén</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1"><?= $total_unidades ?></p>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
            </div>
        </div>

        <section class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-indigo-100 bg-indigo-50/30 flex items-center justify-between">
                <h2 class="text-lg font-bold text-indigo-900 flex items-center gap-2">Listado Detallado</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Medicamento</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Presentación</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Dosis</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Disponibilidad</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php if (count($medicamentos) > 0): ?>
                            <?php foreach ($medicamentos as $med): ?>
                            <tr class="hover:bg-indigo-50/40 transition-colors duration-200 group">
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-slate-100 rounded-lg text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700"><?= htmlspecialchars($med['principio_activo']) ?></p>
                                            <p class="text-xs text-slate-400">ID: #<?= $med['id_medicamento'] ?></p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-600">
                                    <?= htmlspecialchars($med['presentacion']) ?>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap text-center text-sm font-medium text-slate-600">
                                    <?= htmlspecialchars($med['gramaje']) ?>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap text-center">
                                    <?php 
                                        $stock = $med['cantidad_stock'];
                                        if($stock < 15) {
                                            $badgeClass = 'bg-red-50 text-red-600 border-red-200 ring-1 ring-red-200';
                                            $statusText = 'Crítico';
                                        } elseif($stock < 30) {
                                            $badgeClass = 'bg-orange-50 text-orange-600 border-orange-200 ring-1 ring-orange-200';
                                            $statusText = 'Bajo';
                                        } else {
                                            $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-200 ring-1 ring-emerald-200';
                                            $statusText = 'En Stock';
                                        }
                                    ?>
                                    <div class="flex flex-col items-center">
                                        <span class="px-4 py-1 inline-flex text-sm font-bold rounded-lg border <?= $badgeClass ?>">
                                            <?= $stock ?>
                                        </span>
                                        <span class="text-[10px] uppercase font-bold tracking-wide mt-1 text-slate-400"><?= $statusText ?></span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-2">
                                        
                                        <a href="./medicamentos_back/editar_medicamento.php?id=<?= $med['id_medicamento'] ?>" 
                                           class="p-2 bg-white border border-indigo-200 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition shadow-sm" 
                                           title="Editar Stock">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <a href="./medicamentos_back/eliminar_medicamento.php?id=<?= $med['id_medicamento'] ?>" 
                                           onclick="return confirm('¿Seguro que deseas eliminar este medicamento?')"
                                           class="p-2 bg-white border border-red-200 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition shadow-sm" 
                                           title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-500">
                                    No hay medicamentos registrados. ¡Agrega uno nuevo!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>