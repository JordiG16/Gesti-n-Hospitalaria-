<?php
// --- AQUÍ IRÁ TU BACKEND LUEGO ---
// include ...

// --- DATOS DE EJEMPLO ---
$consultas = [
    ['id' => 1, 'paciente' => 'Pedro Paramo', 'doctor' => 'Dr. Roberto Gómez', 'fecha' => '2023-10-30', 'hora' => '09:00 AM', 'estado' => 'Pendiente'],
    ['id' => 2, 'paciente' => 'Susana San Juan', 'doctor' => 'Dr. Roberto Gómez', 'fecha' => '2023-10-30', 'hora' => '10:30 AM', 'estado' => 'En curso'],
    ['id' => 3, 'paciente' => 'Juan Preciado', 'doctor' => 'Dra. María Polo', 'fecha' => '2023-10-29', 'hora' => '04:00 PM', 'estado' => 'Finalizada'],
    ['id' => 4, 'paciente' => 'Dolores Preciado', 'doctor' => 'Dr. Luis Silva', 'fecha' => '2023-10-29', 'hora' => '11:00 AM', 'estado' => 'Cancelada'],
];

$hoy_citas = 8;
$pendientes = 3;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultas Médicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <main class="max-w-7xl mx-auto px-6 py-10">

        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Consultas y Citas</h1>
                <p class="text-slate-500 mt-1">Agenda médica y control de atenciones.</p>
            </div>
            <button class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-xl shadow-lg hover:shadow-teal-500/30 transition flex items-center gap-2 text-sm font-bold transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Agendar Cita
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-teal-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-teal-500 uppercase tracking-wider">Citas para Hoy</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1"><?= $hoy_citas ?></p>
                </div>
                <div class="p-3 bg-teal-50 text-teal-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-orange-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-orange-400 uppercase tracking-wider">Por Atender</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1"><?= $pendientes ?></p>
                </div>
                <div class="p-3 bg-orange-50 text-orange-500 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
            </div>
        </div>

        <section class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-teal-100 bg-teal-50/30 flex items-center justify-between">
                <h2 class="text-lg font-bold text-teal-900">Agenda</h2>
                <div class="relative">
                    <input type="date" class="pl-4 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 text-slate-600">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-teal-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Paciente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Doctor</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Fecha y Hora</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php foreach ($consultas as $cita): ?>
                        <tr class="hover:bg-teal-50/40 transition-colors duration-200">
                            
                            <td class="py-4 px-6 whitespace-nowrap font-medium text-slate-700">
                                <?= htmlspecialchars($cita['paciente']) ?>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-600">
                                <?= htmlspecialchars($cita['doctor']) ?>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <div class="text-sm font-bold text-slate-700"><?= $cita['hora'] ?></div>
                                <div class="text-xs text-slate-400"><?= $cita['fecha'] ?></div>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <?php 
                                    $est = $cita['estado'];
                                    if($est == 'Pendiente') $badge = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                                    elseif($est == 'En curso') $badge = 'bg-blue-100 text-blue-800 border-blue-200 animate-pulse';
                                    elseif($est == 'Finalizada') $badge = 'bg-green-100 text-green-800 border-green-200';
                                    else $badge = 'bg-red-100 text-red-800 border-red-200'; // Cancelada
                                ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border <?= $badge ?>">
                                    <?= $est ?>
                                </span>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Ver Detalles">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>