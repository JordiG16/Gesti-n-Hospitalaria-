<?php
include (__DIR__ . "/../../../../includes/conexiones.php");
include (__DIR__ . "/../../../../includes/funciones.php");

#SI RECIBIMOS POST → GUARDAR CAMBIOS
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id=$_POST["id_usuario"];
    $nombre=$_POST["nombre"];
    $usuario=$_POST["usuarios"];
    $telefono=$_POST["telefono"];
    $direccion=$_POST["direccion"];
    $contrasena=$_POST["contrasena"];

    if ($contrasena === "") {
        $contrasena=null; #no modifica contraseña
    }
    
    modificar($pdo, "usuarios", $nombre, $telefono, $direccion, $usuario, $contrasena, $id);

    header("Location: final_front_mod_usuarios.php?id_usuario=$id&mensaje=Usuario+modificado");
    exit;
}

#SI VIENE POR GET → MOSTRAR FORMULARIO
$id = $_GET["id_usuario"] ?? null;

if (!$id) {
    die("ID no proporcionado.");
}

$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$sql->execute([$id]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuario no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen grid place-items-center py-10 px-4">

  <div class="w-full max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100">

    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Editar Usuario</h1>
            <p class="text-blue-100 mt-1 text-sm">Actualizando datos de: <b><?= htmlspecialchars($user['nombre']) ?></b></p>
        </div>
        
        <a href="eliminar_usuarios.php" class="bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition backdrop-blur-sm group shadow-inner" title="Cancelar">
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

            <input type="hidden" name="id_usuario" value="<?= $id ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nombre Completo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm shadow-sm" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nombre de Usuario</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <input type="text" name="usuarios" value="<?= htmlspecialchars($user['usuarios']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm shadow-sm" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Teléfono</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="text" name="telefono" value="<?= htmlspecialchars($user['telefono']) ?>" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm shadow-sm" required>
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
                            <input type="password" name="contrasena" placeholder="Dejar vacía para no cambiar" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm shadow-sm">
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
                    <textarea name="direccion" rows="2" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm shadow-sm"><?= htmlspecialchars($user['direccion']) ?></textarea>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>

  </div>

</body>
</html>