<div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
    
    <div class="px-6 py-4 bg-blue-50/50 border-b border-blue-100 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Directorio de Pacientes</h2>
            <p class="text-xs text-slate-500">Selecciona un usuario para editar su información.</p>
        </div>
        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
            <?= count($usuarios) ?> Registros
        </span>
    </div>

    <div class="overflow-x-auto max-h-[600px]"> 
        <table class="min-w-full divide-y divide-slate-200">

            <thead class="bg-blue-600 text-white sticky top-0 z-10 shadow-md">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Cuenta</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Contacto</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Afiliado</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">CURP</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Acción</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-slate-100">
                <?php foreach ($usuarios as $user): ?>
                    <tr class="hover:bg-blue-50/60 transition-colors duration-200 group">

                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border-2 border-white shadow-sm shrink-0">
                                    <?= strtoupper(substr($user['nombre'], 0, 1)) ?>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-slate-800 group-hover:text-blue-700 transition-colors">
                                        <?= htmlspecialchars($user['nombre']) ?>
                                    </div>
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
                            <?php if($user['es_afiliado']): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    Afiliado
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                    General
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="py-4 px-6 whitespace-nowrap text-sm text-slate-500 font-mono">
                            <?= htmlspecialchars($user['curp']) ?>
                        </td>

                        <td class="py-4 px-6 whitespace-nowrap text-center">
                            <a href="../procesos/procesos_usuarios/modificar_usuario.php?id_usuario=<?= $user['id_usuario'] ?>"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-blue-200 text-blue-600 text-sm font-medium rounded-lg shadow-sm hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Editar
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>

                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                No hay usuarios registrados.
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>