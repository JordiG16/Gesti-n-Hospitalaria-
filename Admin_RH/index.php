<?php
session_start();
// Verificamos que exista la sesión, si no, pa' fuera
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel RH - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#faf7f5] font-sans text-gray-800">

    <header class="w-full bg-amber-800 shadow-md px-6 py-4 flex items-center justify-between text-white">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h1 class="text-2xl font-bold tracking-wide">Recursos Humanos</h1>
        </div>

        <button id="menu-btn" class="focus:outline-none hover:text-amber-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </header>

    <div id="sidebar" class="fixed top-0 right-0 h-full w-72 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50 flex flex-col">
        <div class="bg-amber-900 text-white px-6 py-6 flex justify-between items-center">
            <h2 class="text-lg font-bold">Mi Perfil</h2>
            <button id="close-menu" class="hover:text-amber-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-6 flex-1 overflow-y-auto">
            <div class="text-center">
                <div class="w-24 h-24 mx-auto bg-amber-100 rounded-full flex items-center justify-center text-amber-700 text-3xl font-bold border-4 border-white shadow-md">
                    <?php echo strtoupper(substr($_SESSION['usuario'], 0, 1)); ?>
                </div>
                <p class="mt-4 text-xl font-bold text-gray-800"><?php echo $_SESSION['usuario']; ?></p>
                <p class="text-sm text-amber-600 font-medium">Administrador RH</p>
            </div>
            <hr class="border-gray-200">
            <nav class="space-y-2">
                <a href="../perfil/editar_perfil.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-amber-800 transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Modificar información
                </a>
                <a href="../perfil/cambiar_contra.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-amber-800 transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Cambiar contraseña
                </a>
                <a href="../login/logout.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition font-medium mt-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Cerrar Sesión
                </a>
            </nav>
        </div>
    </div>

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 hidden z-40 backdrop-blur-sm transition-opacity"></div>

    <main class="max-w-7xl mx-auto px-6 py-10">
        
        <div class="mb-10 bg-white rounded-2xl shadow-sm p-8 border-l-8 border-amber-600 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Hola, <?php echo $_SESSION['usuario']; ?> </h2>
                <p class="text-gray-600 mt-2">Bienvenido al panel de gestión de capital humano.</p>
            </div>
            <div class="hidden md:block">
                <span class="inline-flex items-center justify-center px-4 py-2 border border-amber-200 text-sm font-medium rounded-full text-amber-800 bg-amber-50">
                     <?php echo date('d F, Y'); ?>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <a href="solicitudes/solicitudes.php" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-stone-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-50 rounded-full transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="p-3 bg-amber-100 rounded-xl inline-block text-amber-700 mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-amber-700 transition">Solicitudes de Ingreso</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Gestiona las nuevas postulaciones y procesos de contratación.</p>
                    </div>
                    <span class="text-stone-300 group-hover:text-amber-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                </div>
            </a>

            <a href="plantilla/plantilla.php" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-stone-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-stone-100 rounded-full transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="p-3 bg-stone-200 rounded-xl inline-block text-stone-700 mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-stone-700 transition">Plantilla de Personal</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Consulta el directorio activo de médicos y sus expedientes.</p>
                    </div>
                    <span class="text-stone-300 group-hover:text-stone-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                </div>
            </a>

            <a href="historial_auditoria/historial.php" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-stone-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-orange-50 rounded-full transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="p-3 bg-orange-100 rounded-xl inline-block text-orange-700 mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-orange-700 transition">Historial y Auditoría</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Registro histórico de movimientos y decisiones tomadas.</p>
                    </div>
                    <span class="text-stone-300 group-hover:text-orange-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                </div>
            </a>

            <a href="configuraciones/config.php" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-stone-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gray-100 rounded-full transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="p-3 bg-gray-200 rounded-xl inline-block text-gray-700 mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-gray-700 transition">Ajustes del Sistema</h3>
                        <p class="text-gray-500 mt-2 text-sm leading-relaxed">Configuración general y preferencias del panel.</p>
                    </div>
                    <span class="text-stone-300 group-hover:text-gray-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                </div>
            </a>

        </div>
    </main>

    <script>
        const btn = document.getElementById("menu-btn");
        const closeBtn = document.getElementById("close-menu");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

        function toggleMenu() {
            // Si tiene la clase translate-x-full, está cerrado. Se la quitamos para abrir.
            if (sidebar.classList.contains("translate-x-full")) {
                sidebar.classList.remove("translate-x-full");
                overlay.classList.remove("hidden");
            } else {
                sidebar.classList.add("translate-x-full");
                overlay.classList.add("hidden");
            }
        }

        btn.addEventListener("click", toggleMenu);
        closeBtn.addEventListener("click", toggleMenu);
        overlay.addEventListener("click", toggleMenu);
    </script>
</body>
</html>