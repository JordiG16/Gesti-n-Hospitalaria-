<div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
    
    <div class="px-6 py-4 bg-emerald-50/50 border-b border-emerald-100 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Seleccionar Doctor</h2>
            <p class="text-xs text-slate-500">Elige un doctor de la lista para editar su información.</p>
        </div>
        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">
            <?= count($usuarios) ?> Registros
        </span>
    </div>

    <div class="overflow-x-auto max-h-[600px]"> <table class="min-w-full divide-y divide-slate-200">

            <thead class="bg-emerald-600 text-white sticky top-0 z-10 shadow-md">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Doctor</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Especialidad</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Contacto</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">CURP</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Acción</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-slate-100">
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $user): ?>
                        <tr class="hover:bg-emerald-50/60 transition-colors duration-200 group">

                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold border-2 border-white shadow-sm shrink-0">
                                        <?= strtoupper(substr($user['nombre'], 0, 1)) ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition-colors">
                                            <?= htmlspecialchars($user['nombre']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <?= htmlspecialchars($user['especialidad']) ?>
                                </span>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm text-slate-600 flex items-center gap-2">
                                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <?= htmlspecialchars($user['correo']) ?>
                                    </span>
                                    <span class="text-xs text-slate-400 flex items-center gap-2 mt-1">
                                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        <?= htmlspecialchars($user['telefono']) ?>
                                    </span>
                                </div>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-500 font-mono">
                                <?= htmlspecialchars($user['curp']) ?>
                            </td>

                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <a href="../../procesos/procesos_doctores/modificar_doctores.php?id_doctor=<?= $user['id_doctor'] ?>"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-emerald-200 text-emerald-600 text-sm font-medium rounded-lg shadow-sm hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all duration-200 transform hover:-translate-y-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modificar
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-10 text-center text-slate-400">
                            No hay doctores registrados para modificar.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>