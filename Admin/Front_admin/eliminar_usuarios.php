<?php
include (__DIR__ . "/../procesos/procesos_usuarios/cons_usarios.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Eliminar usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Buscador -->
  <div class="p-6 bg-white shadow-md">
    <form action="./eliminar_usuarios.php" method="GET" class="flex gap-2">
      <input type="text" name="curp" placeholder="Buscar por CURP"
             value="<?= htmlspecialchars($_GET['curp'] ?? '') ?>"
             class="flex-grow border rounded p-2 uppercase">
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Buscar
      </button>
    </form>
  </div>

  <!-- Tabla -->
  <?php include (__DIR__ . "/../componentes/tablas_usuarios/tabla_usuarios_elim.php"); ?>

  <!-- Footer -->
  <?php include (__DIR__ . "/../../includes/foooter.php");?>

</body>
</html>
