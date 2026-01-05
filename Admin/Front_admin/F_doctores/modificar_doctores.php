<?php
include (__DIR__ . "/../../procesos/procesos_doctores/consultar_doctores.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Modificar doctores</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Buscador -->
  <div class="p-6 bg-white shadow-md">
    <form action="./modificar_doctores.php" method="GET" class="flex gap-2">
      <input type="text" name="curp" placeholder="Buscar por CURP"
             value="<?= htmlspecialchars($_GET['curp'] ?? '') ?>"
             class="flex-grow border rounded p-2 uppercase">
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Buscar
      </button>
    </form>
  </div>

  <!-- Tabla -->
  <?php include (__DIR__ . "/../../componentes/tablas_doctores/tabla_mod_doctores.php"); ?>

  <!-- Footer -->
  <?php include (__DIR__ . "/../../../includes/foooter.php");?>

</body>
</html>
