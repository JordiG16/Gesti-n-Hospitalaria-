<?php
include (__DIR__ . "/../../../../includes/conexiones.php");
include (__DIR__ . "/../../../../includes/funciones.php");

#SI RECIBIMOS POST → ACTUALIZAR DOCTOR
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id_doctor"];
    $nombre = $_POST["nombre"];
    $especialidad = $_POST["especialidad"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $curp = $_POST["curp"];
    $contrasena = $_POST["contrasena"];

    # contraseña vacía → no modificar
    if ($contrasena === "") {
        $contrasena = null;
    }

    modificar($pdo, "doctores", $nombre, $telefono, $direccion, $correo, $contrasena, $id);

    # ACTUALIZAR ESPECIALIDAD Y CURP (van fuera de la función modificar)
    $extra = $pdo->prepare("UPDATE doctores SET especialidad=?, curp=? WHERE id_doctor=?");
    $extra->execute([$especialidad, $curp, $id]);

    header("Location: final_front_mod_doc.php?id_doctor=$id&mensaje=Doctor+modificado");
    exit;
}

# SI VIENE GET → MOSTRAR FORMULARIO
$id = $_GET["id_doctor"] ?? null;

if (!$id) {
    die("ID no proporcionado.");
}

$sql = $pdo->prepare("SELECT * FROM doctores WHERE id_doctor = ?");
$sql->execute([$id]);
$doctor = $sql->fetch(PDO::FETCH_ASSOC);

if (!$doctor) {
    die("Doctor no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Doctor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen grid place-items-center py-10 px-4">

  <div class="w-full max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100">

    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Editar Doctor</h1>
            <p class="text-emerald-100 mt-1 text-sm">Modificando datos de: <b><?= htmlspecialchars($doctor['nombre']) ?></b></p>
        </div>
        
        <a href="javascript:history.back()" class="bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition backdrop-blur-sm group shadow-inner" title="Cancelar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>

    <div class="p-8">

        <?php if (isset($_GET["mensaje"])): ?>
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex items-center gap-3">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium"><?= htmlspecialchars($_GET["mensaje"]) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <input type="hidden" name="id_doctor" value="<?= $doctor['id_doctor'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nombre</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="nombre" value="<?= htmlspecialchars($doctor['nombre']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-sm shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Correo Electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="correo" value="<?= htmlspecialchars($doctor['correo']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-sm shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Teléfono</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="text" name="telefono" value="<?= htmlspecialchars($doctor['telefono']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-sm shadow-sm" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Especialidad</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <input type="text" name="especialidad" value="<?= htmlspecialchars($doctor['especialidad']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-sm shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">CURP</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"/></svg>
                            </div>
                            <input type="text" name="curp" value="<?= htmlspecialchars($doctor['curp']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-sm uppercase shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            Contraseña <span class="text-gray-400 font-normal normal-case">(Opcional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="contrasena" placeholder="Dejar vacía para no cambiar" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-sm shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Dirección</label>
                <div class="relative">
                    <div class="absolute top-3 left-3 pointer-events-none text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <textarea name="direccion" rows="2" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-sm shadow-sm"><?= htmlspecialchars($doctor['direccion']) ?></textarea>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-emerald-500/30 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>

  </div>

</body>
</html>