<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso | Sistema Hospitalario</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>

<body class="bg-slate-50 h-screen w-full flex items-center justify-center">

  <div class="bg-white rounded-2xl shadow-2xl overflow-hidden flex w-full max-w-4xl h-[550px] m-4 border border-slate-100">

    <div class="hidden md:flex w-1/2 bg-blue-600 items-center justify-center relative">
        <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
             alt="Hospital" 
             class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-multiply">
        
        <div class="relative z-10 text-white text-center px-8">
            <h2 class="text-3xl font-bold mb-2">Hospital Central</h2>
            <p class="text-blue-100 text-sm">Plataforma de gestión integral para pacientes y personal médico.</p>
        </div>
    </div>

    <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-600 mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Iniciar Sesión</h2>
            <p class="text-sm text-slate-500 mt-1">Ingresa tus credenciales para continuar</p>
        </div>

        <form action="verificar_login.php" method="POST" class="space-y-5">
            
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Usuario</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <input name="usuarios" type="text" placeholder="Ej. juanperez" required
                           class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Contraseña</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <input name="contrasena" type="password" placeholder="••••••••" required
                           class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm">
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                Entrar al Sistema
            </button>

        </form>

        <p class="text-center text-xs text-slate-400 mt-8">
            &copy; 2025 Hospital Central.
        </p>

    </div>
  </div>

</body>
</html>