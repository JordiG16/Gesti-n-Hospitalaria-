<?php
// --- AQUÍ IRÁ TU BACKEND LUEGO ---
// include ...

// --- DATOS DE EJEMPLO (Simulados) ---
$historiales = [
    ['id' => 101, 'paciente' => 'Ana López', 'doctor' => 'Dr. Roberto Gómez', 'fecha' => '2023-10-25', 'diagnostico' => 'Hipertensión Arterial', 'tipo' => 'Consulta General'],
    ['id' => 102, 'paciente' => 'Carlos Ruiz', 'doctor' => 'Dra. María Polo', 'fecha' => '2023-10-24', 'diagnostico' => 'Fractura de radio', 'tipo' => 'Urgencias'],
    ['id' => 103, 'paciente' => 'Elena Nito', 'doctor' => 'Dr. Roberto Gómez', 'fecha' => '2023-10-22', 'diagnostico' => 'Control Diabetes T2', 'tipo' => 'Seguimiento'],
    ['id' => 104, 'paciente' => 'Juan Perez', 'doctor' => 'Dr. Luis Silva', 'fecha' => '2023-10-20', 'diagnostico' => 'Gastroenteritis', 'tipo' => 'Consulta General'],
];

$total_expedientes = 1250; 
$nuevos_mes = 45;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

    <main class="max-w-7xl mx-auto px-6 py-10">

        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Historial Clínico</h1>
                <p class="text-slate-500 mt-1">Archivo digital de expedientes y resultados.</p>
            </div>
            <button class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2.5 rounded-xl shadow-lg hover:shadow-cyan-500/30 transition flex items-center gap-2 text-sm font-bold transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Nuevo Registro
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-cyan-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-cyan-500 uppercase tracking-wider">Total Expedientes</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1"><?= number_format($total_expedientes) ?></p>
                </div>
                <div class="p-3 bg-cyan-50 text-cyan-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-cyan-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-cyan-500 uppercase tracking-wider">Nuevos este mes</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">+<?= $nuevos_mes ?></p>
                </div>
                <div class="p-3 bg-cyan-50 text-cyan-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
            </div>
        </div>

        <section class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-cyan-100 bg-cyan-50/30 flex items-center justify-between">
                <h2 class="text-lg font-bold text-cyan-900 flex items-center gap-2">Registros Recientes</h2>
                <div class="relative">
                    <input type="text" placeholder="Buscar paciente..." class="pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-cyan-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Paciente</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Diagnóstico / Motivo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Atendido por</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php foreach ($historiales as $his): ?>
                        <tr class="hover:bg-cyan-50/40 transition-colors duration-200">
                            
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-bold text-slate-700"><?= htmlspecialchars($his['paciente']) ?></div>
                                <div class="text-xs text-slate-400">Exp: <?= $his['id'] ?></div>
                            </td>

                            <td class="py-4 px-6">
                                <div class="text-sm text-slate-700 font-medium"><?= htmlspecialchars($his['diagnostico']) ?></div>
                                <span class="text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-500 border border-slate-200"><?= $his['tipo'] ?></span>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-600">
                                <?= htmlspecialchars($his['doctor']) ?>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-center text-sm text-slate-500">
                                <?= htmlspecialchars($his['fecha']) ?>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <a href="#" class="text-cyan-600 hover:text-cyan-800 font-medium text-sm flex items-center justify-center gap-1 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Ver Detalles
                                </a>
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