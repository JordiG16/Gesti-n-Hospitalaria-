<!-- HEADER -->
<header class="w-full bg-blue-700 shadow-lg px-6 py-4 flex items-center justify-between">

    <!-- Logo / Título -->
    <h1 class="text-2xl font-semibold tracking-wide">
        Panel Administrador
    </h1>

    <!-- Botón Hamburguesa -->
    <button id="menu-btn" class="text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

</header>

<!-- SIDEBAR (Oculto por defecto) -->
<div id="sidebar" class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">

    <!-- Encabezado del menú -->
    <div class="bg-blue-700 text-white px-6 py-5 flex justify-between items-center">
        <h2 class="text-lg font-semibold">Mi perfil</h2>

        <button id="close-menu" class="text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Contenido del Sidebar -->
    <div class="p-6 space-y-4">

        <div class="text-center">
            <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full shadow-inner"></div>
            <p class="mt-3 text-lg font-semibold text-gray-800">
                <?php echo $_SESSION['usuarios']; ?>
            </p>
            <p class="text-sm text-gray-500">Administrador RH</p>
        </div>

        <hr class="border-gray-300">

        <nav class="space-y-3">
            <a href="../perfil/editar_perfil.php"
               class="block py-2 px-4 rounded-lg bg-gray-100 hover:bg-blue-100 font-medium">
                Modificar mi información
            </a>

            <a href="../perfil/cambiar_contra.php"
               class="block py-2 px-4 rounded-lg bg-gray-100 hover:bg-blue-100 font-medium">
                Cambiar contraseña
            </a>

            <a href="../login/logout.php"
               class="block py-2 px-4 rounded-lg bg-red-500 text-white text-center rounded-xl hover:bg-red-600 font-medium">
                Cerrar sesión
            </a>
        </nav>
    </div>
</div>

<!-- FONDO OSCURO CUANDO EL MENÚ ESTÁ ABIERTO -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<!-- SCRIPT DEL MENÚ -->
<script>
    const btn = document.getElementById("menu-btn");
    const closeBtn = document.getElementById("close-menu");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    btn.addEventListener("click", () => {
        sidebar.classList.remove("translate-x-full");
        overlay.classList.remove("hidden");
    });

    closeBtn.addEventListener("click", () => {
        sidebar.classList.add("translate-x-full");
        overlay.classList.add("hidden");
    });

    overlay.addEventListener("click", () => {
        sidebar.classList.add("translate-x-full");
        overlay.classList.add("hidden");
    });
</script>
