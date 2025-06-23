<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Mapa Interactivo</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-xl overflow-hidden max-w-5xl w-full animate-fade-in">
    
    <!-- Lado visual -->
    <div class="hidden md:block md:w-1/2 relative">
      <img src="assets/img/catedral1.webp" alt="Fondo visual"
           class="absolute inset-0 w-full h-full object-cover z-0" />
      <div class="absolute inset-0 bg-gradient-to-br from-indigo-800/70 to-blue-700/70 z-10"></div>
      <div class="relative z-20 p-10 text-white">
        <h2 class="text-3xl font-bold mb-6">¡Bienvenido de nuevo!</h2>
        <p class="text-lg opacity-90">Explora tu mapa interactivo.</p>
      </div>
    </div>

    <!-- Formulario -->
    <div class="w-full md:w-1/2 p-8 md:p-12">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h2>

      <!-- Contenedor de mensajes de error -->
      <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
        <!-- El mensaje se inserta vía JavaScript -->
      </div>

      <form class="space-y-5" id="login-form">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Usuario</label>
          <input type="text" id="username" name="username" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-400 focus:outline-none transition">
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input type="password" id="password" name="password" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-400 focus:outline-none transition">
        </div>
        <div class="text-right">
          <a href="#" class="text-sm text-indigo-600 hover:underline">¿Olvidaste tu contraseña?</a>
        </div>
        <button type="submit"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-md transition duration-200 shadow-sm">
          Ingresar
        </button>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/script.js"></script>

  <!-- Animación -->
  <style>
    .animate-fade-in {
      animation: fadeIn 1s ease-in-out both;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(12px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</body>
</html>
