<?php
session_start();

include(__DIR__ . "/../../../includes/conexiones.php");
include(__DIR__ . "/../../../includes/funciones.php"); 

$mensaje="";
$tipo_mensaje = "";
$id_med = $_GET['id'] ?? null;

if (!$id_med) { header("Location: ../medicamentos.php"); exit; }

#PROCESAR CON LA FUNCIÓN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $resultado=actualizar_medicamento_completo(
        $pdo,
        $_SESSION['id_admin'],
        $_SESSION['usuario_admin'] ?? 'Admin',
        $id_med,
        $_POST['nombre'],
        $_POST['presentacion'],
        $_POST['gramaje'],
        $_POST['stock']
    );

    if (isset($resultado['error'])) {
        $mensaje = $resultado['error'];
        $tipo_mensaje = "error";
    } else {
        $mensaje = $resultado['mensaje'];
        $tipo_mensaje = $resultado['tipo']; #puede ser success o warning
    }
}

#OBTENER DATOS ACTUALES (Para llenar el form)
try {
    $stmt = $pdo->prepare("SELECT * FROM medicamentos WHERE id_medicamento = ?");
    $stmt->execute([$id_med]);
    $med = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) { echo "Error: " . $e->getMessage(); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Medicamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 flex">
    <main class="flex-1 p-10 ml-0 md:ml-72 transition-all">
        <div class="flex items-center gap-4 mb-6">
            <a href="index.php" class="p-2 rounded-full hover:bg-slate-200 text-slate-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h1 class="text-3xl font-bold text-slate-800">Editar Medicamento</h1>
        </div>

        <?php if ($mensaje): ?>
            <div class="mb-6 p-4 rounded-xl <?= $tipo_mensaje == 'success' ? 'bg-green-100 text-green-700' : ($tipo_mensaje == 'warning' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 max-w-3xl">
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-600 mb-2">Principio Activo</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($med['principio_activo']) ?>" required class="w-full border border-slate-300 rounded-lg p-3 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Presentación</label>
                    <select name="presentacion" class="w-full border border-slate-300 rounded-lg p-3 bg-white">
                        <?php 
                        $opciones = ['Tableta', 'Cápsula', 'Jarabe', 'Solución Inyectable', 'Suspensión', 'Pomada'];
                        foreach($opciones as $op) {
                            $selected = ($med['presentacion'] == $op) ? 'selected' : '';
                            echo "<option value='$op' $selected>$op</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Gramaje</label>
                    <input type="text" name="gramaje" value="<?= htmlspecialchars($med['gramaje']) ?>" required class="w-full border border-slate-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-600 mb-2">Stock Actual</label>
                    <input type="number" name="stock" value="<?= htmlspecialchars($med['cantidad_stock']) ?>" required min="0" class="w-full border border-slate-300 rounded-lg p-3">
                </div>
                <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                    <a href="index.php" class="px-6 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold hover:bg-slate-50">Cancelar</a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200">Actualizar Datos</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>