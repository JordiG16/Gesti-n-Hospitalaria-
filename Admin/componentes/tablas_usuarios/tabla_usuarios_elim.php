<section class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden mt-8">
  
  <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-blue-50/50">
    <div class="flex items-center gap-3">
        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Lista de Usuarios</h2>
            <p class="text-sm text-slate-500">Gestión y baja de pacientes registrados</p>
        </div>
    </div>
    
    <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">
        Total: <?= count($usuarios ?? []) ?>
    </span>
  </div>

  <?php if (isset($_GET["mensaje"])): ?>
    <div class="mx-6 mt-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-medium"><?= htmlspecialchars($_GET["mensaje"]) ?></span>
    </div>
  <?php endif; ?>

  <div class="p-6">
      <div class="overflow-hidden border border-slate-200 rounded-xl shadow-sm">
        <div class="overflow-y-auto max-h-[500px]">
            <table class="min-w-full divide-y divide-slate-200">
            
            <thead class="bg-blue-600 text-white sticky top-0 z-10 shadow-md">
                <tr>
                    <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">Usuario</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">Correo</th>
                    <th class="py-4 px-6 text-center text-xs font-semibold uppercase tracking-wider">Estatus</th>
                    <th class="py-4 px-6 text-left text-xs font-semibold uppercase tracking-wider">CURP</th>
                    <th class="py-4 px-6 text-center text-xs font-semibold uppercase tracking-wider">Acción</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-slate-100">
                <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $user): ?>
                    <tr class="hover:bg-blue-50/60 transition-colors duration-200 group">
                    
                    <td class="py-4 px-6 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border-2 border-white shadow-sm">
                                    <?= strtoupper(substr($user['nombre'], 0, 1)) ?>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-slate-800"><?= htmlspecialchars($user['nombre']) ?></div>
                            </div>
                        </div>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-600 font-medium">
                        @<?= htmlspecialchars($user['usuarios']) ?>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-500">
                        <?= htmlspecialchars($user['correo']) ?>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap text-center">
                        <?php if($user['es_afiliado'] == 1): ?>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                Afiliado
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                General
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-500 font-mono">
                        <?= htmlspecialchars($user['curp']) ?>
                    </td>

                    <td class="py-4 px-6 whitespace-nowrap text-center">
                        <div class="flex justify-center">
                            <a href="../procesos/procesos_usuarios/eliminar_usuarios.php?id_usuario=<?= $user['id_usuario'] ?>"
                               onclick="return confirm('¿Estás seguro de que deseas eliminar al usuario <?= $user['nombre'] ?>? Esta acción es irreversible.')"
                               class="group bg-white border border-red-200 text-red-500 hover:bg-red-50 hover:border-red-300 p-2 rounded-lg transition-all duration-200 shadow-sm"
                               title="Eliminar Usuario">
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
                            <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <p class="text-lg font-medium text-slate-600">No se encontraron usuarios</p>
                            <p class="text-sm">La base de datos está vacía.</p>
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