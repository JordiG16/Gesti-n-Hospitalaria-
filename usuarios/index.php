<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal del Paciente | Hospital Central</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <header class="bg-white shadow-sm sticky top-0 z-40 h-16 flex items-center justify-between px-4 lg:px-8">
        <div class="flex items-center gap-4">
            <button id="menu-btn" class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            
            <div class="flex items-center gap-2">
                <div class="bg-sky-500 text-white p-1.5 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight hidden sm:block">Hospital Central</h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-sm font-medium text-slate-600 hidden md:block">Hola, <?= $_SESSION['usuario_paciente'] ?></span>
            <div class="h-10 w-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 font-bold border border-sky-200">
                <?= strtoupper(substr($_SESSION['usuario_paciente'], 0, 1)) ?>
            </div>
        </div>
    </header>

    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity"></div>

    <aside id="sidebar" class="fixed top-0 left-0 h-full w-80 bg-white z-50 transform -translate-x-full sidebar-transition shadow-2xl flex flex-col">
        <div class="h-full flex flex-col bg-white">
    
    <div class="h-32 bg-gradient-to-r from-cyan-600 to-blue-600 p-6 flex items-center gap-4 relative overflow-hidden shrink-0">
        
        <div class="absolute top-0 right-0 -mt-2 -mr-2 w-20 h-20 bg-white opacity-10 rounded-full pointer-events-none"></div>

        <button id="close-menu" class="absolute top-4 right-4 text-white/70 hover:text-white transition p-1 hover:bg-white/10 rounded-full focus:outline-none z-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <div class="w-14 h-14 rounded-full border-2 border-white/30 flex items-center justify-center text-white font-bold text-xl bg-white/10 backdrop-blur-sm z-10">
            <?php echo strtoupper(substr($_SESSION['usuario'] ?? 'U', 0, 1)); ?>
        </div>
        
        <div class="text-white z-10 overflow-hidden">
            <h3 class="font-bold text-lg leading-tight truncate pr-8"><?php echo $_SESSION['usuario_paciente'] ?? 'Paciente'; ?></h3>
            <a href="../includes/cambiar_contraseña.php" class="text-xs text-cyan-100 hover:text-white flex items-center gap-1 mt-1 transition group">
                Cambiar contraseña
                <span class="group-hover:translate-x-1 transition-transform">&rsaquo;</span>
            </a>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        
        <a href="index2.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Inicio
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Agenda Médica</p>
        </div>
        
        <a href="citas/agendar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <span class="text-slate-400 group-hover:text-cyan-500 font-bold text-lg w-5 text-center flex justify-center">+</span>
            Agendar Nueva Cita
        </a>
        <a href="citas/mis_citas.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Mis Citas Programadas
        </a>
        <a href="citas/cancelar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-red-50 hover:text-red-600 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            Cancelar Cita
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laboratorio Clínico</p>
        </div>

        <a href="laboratorio/solicitar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Solicitar Estudios
        </a>
        <a href="laboratorio/resultados.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Consultar Resultados
        </a>
        <a href="laboratorio/cancelar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-red-50 hover:text-red-600 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Cancelar Solicitud
        </a>
    </nav>

    <div class="p-4 border-t border-slate-100">
        <a href="../includes/cerrar_sesion.php" class="flex items-center justify-center gap-2 w-full py-3 border border-slate-200 rounded-xl text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Cerrar Sesión
        </a>
    </div>
</div>
    </aside>


    <main class="w-full">
        
        <div class="relative bg-sky-800 h-[450px] flex items-center justify-center text-center px-4 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586773860418-d37222d8fce3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" 
                 alt="Edificio del Hospital" class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-multiply">
            
            <div class="relative z-10 max-w-4xl">
                <span class="inline-block py-1 px-3 rounded-full bg-sky-500/30 text-sky-100 text-sm font-bold mb-4 backdrop-blur-sm border border-sky-400/30">Bienvenido a tu Portal de Salud</span>
                <h2 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">Tu salud, en tus manos, <br>en todo momento.</h2>
                <p class="text-sky-100 text-lg md:text-xl mb-10 max-w-2xl mx-auto">Gestiona tus citas médicas, consulta tus resultados de laboratorio y accede a tu historial desde cualquier lugar, de forma segura.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="citas/agendar.php" class="bg-white text-sky-700 px-8 py-4 rounded-full font-bold hover:bg-sky-50 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Agendar Cita Ahora
                    </a>
                </div>
            </div>
        </div>

        <section class="max-w-7xl mx-auto px-6 py-20 -mt-16 relative z-20">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 hover:shadow-2xl transition-all duration-300 text-center group relative overflow-hidden">
                     <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800 mb-3">Citas Médicas</h4>
                        <p class="text-slate-500 mb-6">Agenda, reprograma o cancela tus consultas con nuestros especialistas sin filas ni esperas.</p>
                        <a href="citas/mis_citas.php" class="text-sky-600 font-bold hover:text-sky-700 inline-flex items-center gap-1">Ir a mis citas <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 hover:shadow-2xl transition-all duration-300 text-center group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden mx-auto mb-6 shadow-md group-hover:scale-105 transition-transform">
                            <img src="https://images.unsplash.com/photo-1579165466741-7f35e4755660?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80" 
                                 alt="Muestras de Laboratorio" class="w-full h-full object-cover">
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800 mb-3">Laboratorio Clínico</h4>
                        <p class="text-slate-500 mb-6">Solicita estudios y consulta tus resultados en línea de forma segura y confidencial.</p>
                        <a href="laboratorio/resultados.php" class="text-teal-600 font-bold hover:text-teal-700 inline-flex items-center gap-1">Ver resultados <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 hover:shadow-2xl transition-all duration-300 text-center group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-slate-800 mb-3">Mi Perfil</h4>
                        <p class="text-slate-500 mb-6">Mantén tu información personal y de contacto actualizada para una mejor atención.</p>
                        <a href="perfil/mi_perfil.php" class="text-indigo-600 font-bold hover:text-indigo-700 inline-flex items-center gap-1">Gestionar perfil <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-slate-900 text-slate-400 py-12 text-center mt-auto">
            <div class="max-w-7xl mx-auto px-6">
                <div class="mb-6 flex items-center justify-center gap-2 text-white">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="text-2xl font-bold">Hospital Central</span>
                </div>
                <p class="mb-4">Comprometidos con tu bienestar y el de tu familia.</p>
                <div class="flex flex-col md:flex-row justify-center gap-4 text-sm font-medium">
                    <p>Llamanos: (+52) 7205488011</p>
                    <p class="hidden md:block">|</p>
                    <p> Urgencias: 911</p>
                    <p class="hidden md:block">|</p>
                    <p>contacto@hospitalcentral.com</p>
                </div>
                 <p class="mt-8 text-xs border-t border-slate-800 pt-6">&copy; 2025 Hospital Central. Todos los derechos reservados.</p>
            </div>
        </footer>

    </main>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const closeBtn = document.getElementById('close-menu');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
            } else {
                overlay.classList.remove('hidden');
            }
        }

        menuBtn.addEventListener('click', toggleMenu);
        closeBtn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
    </script>

</body>
</html>