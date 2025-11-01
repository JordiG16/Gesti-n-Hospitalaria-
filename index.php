<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Administrador</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans">
  <!-- NAVBAR -->
  <header class="bg-blue-700 text-white p-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">Panel Administrativo</h1>
    <nav>
      <a href="logout.php" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 transition ml-3">Cerrar sesión</a>
    </nav>
  </header>

  <!-- CONTENIDO -->
  <main class="p-10 grid grid-cols-1 md:grid-cols-2 gap-10">
    <!-- SECCIÓN USUARIOS -->
    <section class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-blue-600">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        👤 Área de Usuarios
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Consultar Usuario -->
        <div class="bg-blue-100 p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer">
          <h3 class="text-xl font-semibold mb-2">Consultar Usuario</h3>
          <p class="text-gray-700 text-sm mb-3">Busca información de un usuario registrado.</p>
          <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Entrar</button>
        </div>

        <!-- Modificar Usuario -->
        <div class="bg-green-100 p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer">
          <h3 class="text-xl font-semibold mb-2">Modificar Usuario</h3>
          <p class="text-gray-700 text-sm mb-3">Edita los datos de un usuario existente.</p>
          <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Entrar</button>
        </div>

        <!-- Eliminar Usuario -->
        <div class="bg-red-100 p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer">
          <h3 class="text-xl font-semibold mb-2">Eliminar Usuario</h3>
          <p class="text-gray-700 text-sm mb-3">Elimina un usuario del sistema.</p>
          <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Entrar</button>
        </div>

        <!-- Afiliar Usuario -->
        <div class="bg-yellow-100 p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer">
          <h3 class="text-xl font-semibold mb-2">Afiliar Usuario</h3>
          <p class="text-gray-700 text-sm mb-3">Afílialo a un plan médico o seguro.</p>
          <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Entrar</button>
        </div>
      </div>
    </section>

    <!-- SECCIÓN MÉDICOS -->
    <section class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-emerald-600">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        🩺 Área de Doctores
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Agregar Médico -->
        <div class="bg-emerald-100 p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer">
          <h3 class="text-xl font-semibold mb-2">Agregar Médico</h3>
          <p class="text-gray-700 text-sm mb-3">Registra un nuevo médico en el sistema.</p>
          <button class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">Entrar</button>
        </div>

        <!-- Eliminar Médico -->
        <div class="bg-red-100 p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer">
          <h3 class="text-xl font-semibold mb-2">Eliminar Médico</h3>
          <p class="text-gray-700 text-sm mb-3">Elimina un médico del registro.</p>
          <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Entrar</button>
        </div>

        <!-- Consultar Médico -->
        <div class="bg-blue-100 p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer sm:col-span-2">
          <h3 class="text-xl font-semibold mb-2">Consultar Datos del Médico</h3>
          <p class="text-gray-700 text-sm mb-3">Busca información detallada de los médicos.</p>
          <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Entrar</button>
        </div>
      </div>
    </section>
        
      <section>
          </div>

        <div>
          <h3 class=>

      </section>
  </main>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-white text-center py-3 mt-10">
    <p class="text-sm">&copy; <?php echo date("Y"); ?> Sistema Gestor Hospitalario | Área Administrativa</p>
  </footer>
</body>
</html>
