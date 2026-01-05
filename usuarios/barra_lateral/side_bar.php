<aside class="w-72 bg-white h-screen shadow-xl flex flex-col fixed left-0 top-0 z-50">
    <div class="h-32 bg-gradient-to-r from-cyan-600 to-blue-600 p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-2 -mr-2 w-20 h-20 bg-white opacity-10 rounded-full"></div>
        
        <div class="w-14 h-14 rounded-full border-2 border-white/30 flex items-center justify-center text-white font-bold text-xl bg-white/10 backdrop-blur-sm">
            <?php echo strtoupper(substr($_SESSION['usuario'] ?? 'U', 0, 1)); ?>
        </div>
        
        <div class="text-white z-10">
            <h3 class="font-bold text-lg leading-tight"><?php echo $_SESSION['usuario_paciente'] ?? 'Paciente'; ?></h3>
            <a href="../perfil/mi_perfil.php" class="text-xs text-cyan-100 hover:text-white flex items-center gap-1 mt-1 transition">
                Mi Perfil de Salud <span class="text-[10px]">&rsaquo;</span>
            </a>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        
        <a href="../index2.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Inicio
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Agenda Médica</p>
        </div>
        
        <a href="../citas/agendar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <span class="text-slate-400 group-hover:text-cyan-500 font-bold text-lg">+</span>
            Agendar Nueva Cita
        </a>
        <a href="../citas/mis_citas.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Mis Citas Programadas
        </a>
        <a href="../citas/cancelar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-red-50 hover:text-red-600 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            Cancelar Cita
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laboratorio Clínico</p>
        </div>

        <a href="../laboratorio/solicitar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Solicitar Estudios
        </a>
        <a href="../laboratorio/resultados.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Consultar Resultados
        </a>
        <a href="../laboratorio/cancelar.php" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-red-50 hover:text-red-600 rounded-lg transition group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Cancelar Solicitud
        </a>

    </nav>

    <div class="p-4 border-t border-slate-100">
        <a href="../perfil/cerrar_sesion.php" class="flex items-center justify-center gap-2 w-full py-3 border border-slate-200 rounded-xl text-slate-600 hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Cerrar Sesión
        </a>
    </div>
</aside>