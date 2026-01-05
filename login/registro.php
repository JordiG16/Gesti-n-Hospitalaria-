<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registro | Sistema Hospitalario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Contenedor principal -->
  <main class="flex-grow flex items-center justify-center">
    <form action="verificar_registro.php" method="POST" class="bg-white p-8 rounded-2xl shadow-md w-96">
      <h2 class="text-2xl font-bold text-center mb-6">Crear cuenta</h2>

      <!-- Campo nombre -->
      <input name="nombre" type="text" placeholder="Nombre completo"
             class="w-full p-2 border rounded mb-4" required>

      <!-- Campo usuario -->
      <input name="usuarios" type="text" placeholder="Nombre de usuario"
             class="w-full p-2 border rounded mb-4" required>

      <!-- Campo correo -->
      <input name="correo" type="email" placeholder="Correo electrónico"
             class="w-full p-2 border rounded mb-4" required>

      <!-- Campo contraseña -->
      <input name="contrasena" type="password" placeholder="Contraseña"
             class="w-full p-2 border rounded mb-4" required>

      <!-- Campo telefono -->
      <input name="telefono" type="tel" placeholder="Teléfono"
             class="w-full p-2 border rounded mb-4" required>

      <!-- Campo CURP -->
      <input name="curp" type="text" placeholder="CURP" maxlength="18"
             class="w-full p-2 border rounded mb-4 uppercase" required>

      <!-- Boton de registro -->
      <button type="submit"
              class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
        Registrarse
      </button>

      <!-- Enlace para iniciar sesión -->
      <p class="text-sm text-center mt-4">
        ¿Ya tienes cuenta?
        <a href="login.php" class="text-blue-600 hover:underline">Inicia sesión aquí</a>
      </p>
    </form>
  </main>
  <?php include("../includes/foooter.php"); ?>
</body>
</html>