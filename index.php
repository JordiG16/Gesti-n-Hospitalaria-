<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen font-sans text-slate-800 flex flex-col"> 

    <header class="w-full shadow-md sticky top-0 z-50"> 
        <?php include("./includes/header.php"); ?>
    </header>

    <main class="flex-grow max-w-7xl mx-auto w-full px-6 py-10">
        
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-bold text-slate-800">Panel General</h1>
            <p class="text-slate-500 mt-2">Gestión centralizada de usuarios, cuerpo médico e inventario.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <section class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="bg-blue-600 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Área de Usuarios
                    </h2>
                    <span class="bg-blue-500 text-blue-50 text-xs px-2 py-1 rounded-full font-medium">Pacientes</span>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 flex-grow">
                    
                    <div class="group bg-blue-50 rounded-xl p-5 hover:bg-blue-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-blue-100 hover:border-blue-600"
                         onclick="window.location.href='Admin/Front_admin/agregar_usuarios.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-blue-600 group-hover:text-blue-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <span class="text-blue-300 group-hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Agregar Usuario</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-blue-100">Registrar nuevo paciente.</p>
                    </div>

                    <div class="group bg-blue-50 rounded-xl p-5 hover:bg-blue-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-blue-100 hover:border-blue-600"
                         onclick="window.location.href='Admin/Front_admin/eliminar_usuarios.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-blue-600 group-hover:text-blue-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </div>
                            <span class="text-blue-300 group-hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Eliminar / Ver</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-blue-100">Gestión de bajas.</p>
                    </div>

                    <div class="group bg-blue-50 rounded-xl p-5 hover:bg-blue-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-blue-100 hover:border-blue-600"
                         onclick="window.location.href='Admin/Front_admin/modificar_usuarios.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-blue-600 group-hover:text-blue-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <span class="text-blue-300 group-hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Modificar Datos</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-blue-100">Actualizar información.</p>
                    </div>

                    <div class="group bg-blue-50 rounded-xl p-5 hover:bg-blue-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-blue-100 hover:border-blue-600"
                     onclick="window.location.href='Admin/Front_admin/historial.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-blue-600 group-hover:text-blue-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="text-blue-300 group-hover:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Historial Clínico</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-blue-100">Estudios y resultados.</p>
                    </div>

                </div>
            </section>


            <section class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="bg-emerald-600 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Área de Doctores
                    </h2>
                    <span class="bg-emerald-500 text-emerald-50 text-xs px-2 py-1 rounded-full font-medium">Médicos</span>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 flex-grow">
                    
                    <div class="group bg-emerald-50 rounded-xl p-5 hover:bg-emerald-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-emerald-100 hover:border-emerald-600"
                         onclick="window.location.href='Admin/Front_admin/F_doctores/agregar_doctores.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-emerald-600 group-hover:text-emerald-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <span class="text-emerald-300 group-hover:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Agregar Doctor</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-emerald-100">Alta de personal médico.</p>
                    </div>

                    <div class="group bg-emerald-50 rounded-xl p-5 hover:bg-emerald-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-emerald-100 hover:border-emerald-600"
                         onclick="window.location.href='Admin/Front_admin/F_doctores/eliminar_doctores.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-emerald-600 group-hover:text-emerald-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="text-emerald-300 group-hover:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Eliminar / Ver</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-emerald-100">Gestión de personal.</p>
                    </div>

                    <div class="group bg-emerald-50 rounded-xl p-5 hover:bg-emerald-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-emerald-100 hover:border-emerald-600"
                         onclick="window.location.href='Admin/Front_admin/F_doctores/modificar_doctores.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-emerald-600 group-hover:text-emerald-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                            <span class="text-emerald-300 group-hover:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Editar Perfil</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-emerald-100">Datos profesionales.</p>
                    </div>

                    <div class="group bg-emerald-50 rounded-xl p-5 hover:bg-emerald-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-emerald-100 hover:border-emerald-600"
                         onclick="window.location.href='Admin/Front_admin/F_doctores/consultas.php'">
                        <div class="flex justify-between items-start">
                            <div class="p-2 bg-white rounded-lg text-emerald-600 group-hover:text-emerald-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <span class="text-emerald-300 group-hover:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-bold text-slate-800 group-hover:text-white">Consultas</h3>
                        <p class="text-xs text-slate-500 mt-1 group-hover:text-emerald-100">Registro de atenciones.</p>
                    </div>

                </div>
            </section>


            <section class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Inventario y Farmacia
        </h2>
        <span class="bg-indigo-500 text-indigo-50 text-xs px-2 py-1 rounded-full font-medium">Stock</span>
    </div>
    
    <div class="p-6">
        <div class="group bg-indigo-50 rounded-xl p-6 hover:bg-indigo-600 hover:shadow-lg transition-all duration-300 cursor-pointer border border-indigo-100 hover:border-indigo-600 flex flex-col md:flex-row items-center justify-between gap-4"
             onclick="window.location.href='Admin/medicamentos/medicamentos.php'">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-white rounded-xl text-indigo-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.414 4.586a2 2 0 00-2.828 0L4.586 16.586a2 2 0 002.828 2.828l12-12a2 2 0 000-2.828zM10.5 13.5l3-3"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 group-hover:text-white">Control de Medicamentos</h3>
                    <p class="text-slate-500 group-hover:text-indigo-100">Gestión de entradas, salidas y auditoría de stock.</p>
                </div>
            </div>
            
            <button class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-semibold shadow-sm group-hover:bg-indigo-500 group-hover:text-white transition">
                Revisar Stock
            </button>
        </div>
    </div>
</section>

        </div>
    </main>

    <footer class="mt-auto">
        <?php include("includes/foooter.php"); ?>
    </footer>

</body>
</html>