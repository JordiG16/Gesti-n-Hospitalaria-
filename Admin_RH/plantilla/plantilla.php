<?php
session_start();
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
            <div class="flex gap-3">
                <input type="text" placeholder="Buscar empleado..." class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <a href="index.php" class="text-gray-500 hover:text-gray-700 self-center text-sm">&larr; Volver</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start space-x-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                    JR
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900">Dr. Juan Ramirez</h3>
                    <p class="text-xs text-blue-600 font-semibold mb-1">Cardiología</p>
                    <p class="text-xs text-gray-500">Turno Matutino</p>
                    <p class="text-xs text-gray-400 mt-2">ID: DOC-001</p>
                </div>
                <button class="text-gray-400 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                </button>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-start space-x-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-lg">
                    LM
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900">Lic. Laura Méndez</h3>
                    <p class="text-xs text-green-600 font-semibold mb-1">Administración</p>
                    <p class="text-xs text-gray-500">Tiempo Completo</p>
                    <p class="text-xs text-gray-400 mt-2">ID: ADM-045</p>
                </div>
                <button class="text-gray-400 hover:text-blue-600">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                </button>
            </div>

        </div>
    </div>
</body>
</html>