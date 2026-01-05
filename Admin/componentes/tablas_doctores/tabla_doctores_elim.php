<section class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden mt-8">
  
  <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-emerald-50/50">
    <div class="flex items-center gap-3">
        <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Directorio Médico</h2>
            <p class="text-sm text-slate-500">Listado de doctores activos en el sistema</p>
        </div>
    </div>
    
    <span class="bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold">
        Total: <?= count($usuarios ?? []) ?>
    </span>
  </div>

  <?php if (isset($_GET["mensaje"])): ?>
    <div class="mx-6 mt-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex items-center justify-between">
      <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span><?= htmlspecialchars($_GET["mensaje"]) ?></span>
      </div>
      <button onclick="this.parentElement.style.display='none'" class="text-green-500 hover:text-green-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
    </div>
  <?php endif; ?>

  <div class="p-6">
      <div class="overflow-hidden border border-slate-200 rounded-xl shadow-sm">
        <div class="overflow-y-auto max-h-[500px]"> <table class="min-w-full divide-y divide-slate-200">
            
            <thead class="bg-emerald-600 text-white sticky top-0 z-10 shadow-md">
                <tr>
                <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">Doctor</th>
                <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">Especialidad</th>
                <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">Contacto</th>
                <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">CURP</th>
                <th class="py-4 px-6 text-center text-xs font-semibold uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-slate-100">
                <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $user): ?>
                    <tr class="hover:bg-emerald-50/60 transition-colors duration-200">
                    
                    <td class="py-4 px-6 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold border-2 border-white shadow-sm">
                                    <?= strtoupper(substr($user['nombre'], 0, 1)) ?>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-slate-800"><?= htmlspecialchars($user['nombre']) ?></div>
                                <div class="text-xs text-slate-500">ID: <?= $user['id_doctor'] ?></div>
                            </div>
                        </div>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                        <?= htmlspecialchars($user['especialidad']) ?>
                        </span>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap">
                        <div class="text-sm text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <?= htmlspecialchars($user['correo']) ?>
                        </div>
                        <div class="text-xs text-slate-500 mt-1 flex items-center gap-2">
                             <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <?= htmlspecialchars($user['telefono']) ?>
                        </div>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-600 font-mono">
                        <?= htmlspecialchars($user['curp']) ?>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap text-center">
                        <div class="flex justify-center">
                            <a href="../../procesos/procesos_doctores/eliminar_doctores.php?id_doctor=<?= $user['id_doctor'] ?>"
                            onclick="return confirm('¿Estás seguro de que deseas eliminar al doctor <?= $user['nombre'] ?>? Esta acción no se puede deshacer.')"
                            class="group bg-white border border-red-200 text-red-500 hover:bg-red-50 hover:border-red-300 p-2 rounded-lg transition-all duration-200 shadow-sm"
                            title="Eliminar Doctor">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    </td>

                    </tr>
                <?php endforeach; ?>

                <?php else: ?>
                <tr>
                    <td colspan="6" class="py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <p class="text-lg font-medium text-slate-600">No se encontraron doctores</p>
                            <p class="text-sm">Agrega un nuevo doctor para comenzar.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>

            </table>
        </div>
      </div>
  </div>

</section>