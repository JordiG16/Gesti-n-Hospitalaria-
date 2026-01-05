<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial | RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-4xl mx-auto p-8">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Registro de Actividades</h1>
            <a href="index.php" class="text-blue-600 hover:underline text-sm font-medium">&larr; Volver</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <ul class="space-y-6">
                
                <li class="relative flex gap-6 items-start">
                    <div class="absolute left-0 top-0 mt-1.5 -ml-1.5 w-3 h-3 bg-blue-500 rounded-full border-2 border-white"></div>
                    <div class="flex-1 border-l-2 border-gray-100 pl-6 pb-6">
                        <p class="text-xs text-gray-400 font-mono mb-1">Hoy, 10:42 AM</p>
                        <p class="text-sm text-gray-800 font-medium">Jordi Gómez (RH) <span class="font-normal text-gray-500">creó un nuevo expediente.</span></p>
                        <p class="text-xs text-gray-500 mt-1 bg-gray-50 p-2 rounded inline-block">Usuario: Dr. Simi (Alta médica)</p>
                    </div>
                </li>

                <li class="relative flex gap-6 items-start">
                    <div class="absolute left-0 top-0 mt-1.5 -ml-1.5 w-3 h-3 bg-red-400 rounded-full border-2 border-white"></div>
                    <div class="flex-1 border-l-2 border-gray-100 pl-6 pb-6">
                        <p class="text-xs text-gray-400 font-mono mb-1">Ayer, 18:30 PM</p>
                        <p class="text-sm text-gray-800 font-medium">Sistema <span class="font-normal text-gray-500">eliminó registro de medicamento caducado.</span></p>
                    </div>
                </li>

                <li class="relative flex gap-6 items-start">
                    <div class="absolute left-0 top-0 mt-1.5 -ml-1.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                    <div class="flex-1 border-l-2 border-gray-100 pl-6">
                        <p class="text-xs text-gray-400 font-mono mb-1">02 Ene, 09:00 AM</p>
                        <p class="text-sm text-gray-800 font-medium">Admin General <span class="font-normal text-gray-500">actualizó los permisos de RH.</span></p>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</body>
</html>