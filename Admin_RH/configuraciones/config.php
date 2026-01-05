<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ajustes | RH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-3xl mx-auto p-8">
        
        <div class="mb-8 border-b pb-4 flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Configuración</h1>
                <p class="text-sm text-gray-500">Preferencias de tu cuenta y del panel.</p>
            </div>
            <a href="index.php" class="text-gray-500 hover:text-blue-600 text-sm">Cancelar</a>
        </div>

        <form action="" method="POST" class="space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Información Personal
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                        <input type="text" value="Jordi Gómez" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Correo Electrónico</label>
                        <input type="email" value="jordi@hospital.com" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Seguridad
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Contraseña Actual</label>
                        <input type="password" placeholder="••••••" class="w-full border rounded-lg px-3 py-2 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nueva Contraseña</label>
                        <input type="password" placeholder="Mínimo 8 caracteres" class="w-full border rounded-lg px-3 py-2 text-sm outline-none">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>

</body>
</html>