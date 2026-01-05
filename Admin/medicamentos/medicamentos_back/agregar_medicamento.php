<?php
session_start();
include(__DIR__ . "/../../../includes/conexiones.php");
include(__DIR__ . "/../../../includes/funciones.php"); 

$mensaje="";
$tipo_mensaje="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    #Llamamos a TU función
    $resultado=crear_medicamento(
        $pdo, 
        $_SESSION['id_admin'], 
        $_SESSION['usuario_admin'] ?? 'Admin',
        $_POST['nombre'], 
        $_POST['presentacion'], 
        $_POST['gramaje'], 
        $_POST['stock']
    );

    #Procesamos la respuesta de la función
    if (isset($resultado['error'])) {
        $mensaje = $resultado['error'];
        $tipo_mensaje = "error";
    } else {
        $mensaje=$resultado['mensaje'];
        $tipo_mensaje = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Medicamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex">

    <main class="flex-1 p-10 ml-0 md:ml-72">
        <h1 class="text-3xl font-bold text-slate-800 mb-6">Nuevo Medicamento</h1>

        <?php if ($mensaje): ?>
            <div class="mb-6 p-4 rounded-xl <?= $tipo_mensaje == 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 max-w-3xl">
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Principio Activo (Nombre)</label>
                    <input type="text" name="nombre" required class="w-full border border-slate-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Ej. Paracetamol">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Presentación</label>
                    <select name="presentacion" class="w-full border border-slate-300 rounded-lg p-3 bg-white">
                        <option>Tableta</option>
                        <option>Cápsula</option>
                        <option>Jarabe</option>
                        <option>Solución Inyectable</option>
                        <option>Suspensión</option>
                        <option>Pomada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Gramaje / Dosis</label>
                    <input type="text" name="gramaje" required class="w-full border border-slate-300 rounded-lg p-3" placeholder="Ej. 500mg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Cantidad Inicial (Stock)</label>
                    <input type="number" name="stock" required min="0" class="w-full border border-slate-300 rounded-lg p-3" placeholder="Ej. 100">
                </div>
                <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                    <a href="index.php" class="px-6 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold hover:bg-slate-50">Cancelar</a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200">Guardar Medicamento</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>