<?php
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes | RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-7xl mx-auto p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Solicitudes de Ingreso</h1>
                <p class="text-sm text-gray-500">Gestión de postulantes y nuevas contrataciones.</p>
            </div>
            <a href="index.php" class="text-blue-600 hover:underline text-sm font-medium">&larr; Volver al Panel</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b">
                        <th class="p-4 font-semibold">Candidato</th>
                        <th class="p-4 font-semibold">Puesto Solicitado</th>
                        <th class="p-4 font-semibold">Fecha</th>
                        <th class="p-4 font-semibold">Estado</th>
                        <th class="p-4 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-medium text-gray-900">Ana Karen H.</td>
                        <td class="p-4 text-gray-600">Enfermería General</td>
                        <td class="p-4 text-gray-500">02 Ene 2026</td>
                        <td class="p-4">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-bold">Pendiente</span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Ver CV</button>
                            <button class="text-green-600 hover:text-green-800 font-medium">Aceptar</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-medium text-gray-900">Carlos Ruiz</td>
                        <td class="p-4 text-gray-600">Soporte TI</td>
                        <td class="p-4 text-gray-500">01 Ene 2026</td>
                        <td class="p-4">
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-bold">Rechazado</span>
                        </td>
                        <td class="p-4 text-right">
                            <span class="text-gray-400">Archivado</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>     