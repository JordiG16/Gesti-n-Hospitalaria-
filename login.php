<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Login | Sistema Hospitalario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
  <form action="verificar_login.php" method="POST" class="bg-white p-8 rounded-2xl shadow-md w-96">
    <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>

    <input name="usuario" type="text" placeholder="usuario" class="w-full p-2 border rounded mb-4" required>
    <input name="contrasena" type="password" placeholder="contraseña" class="w-full p-2 border rounded mb-4" required>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Entrar</button>
  </form>
</body>
</html>
