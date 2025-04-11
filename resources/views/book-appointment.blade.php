<x-app-layout>
    <!-- Sección de redes sociales -->
    <div class="bg-gray-800 py-2">
        <div class="max-w-7xl mx-auto flex items-center justify-start space-x-4 px-4 sm:px-6">
            <h3 class="text-xl font-bold text-white">Síguenos en redes sociales</h3>
            <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer">
                <img src="/assets/icons/facebook.svg" alt="Facebook" class="w-6 h-6 object-contain">
            </a>
            <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer">
                <img src="/assets/icons/instagram.svg" alt="Instagram" class="w-6 h-6 object-contain">
            </a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
                <img src="/assets/icons/twitter.svg" alt="Twitter" class="w-6 h-6 object-contain">
            </a>
        </div>
    </div>

    <!-- Sección con imagen de fondo y formulario -->
    <div class="relative py-12 bg-gray-100">
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 z-0">
            <img src="/images/img1.webp" alt="Fondo" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
        
        <!-- Contenedor del formulario con márgenes -->
        <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-0 my-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <!-- Contenido del formulario -->
                <form class="space-y-4">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Pida su cita</h2>

                    <!-- Campos del formulario -->
                    <div class="space-y-4">
                        <!-- Nombre -->
                        <div class="text-left">
                            <label for="name" class="block text-lg font-bold text-gray-700 mb-2">Nombre:</label>
                            <input type="text" id="name" name="name" placeholder="Ingrese su nombre" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <!-- Apellidos -->
                        <div class="text-left">
                            <label for="surnames" class="block text-lg font-bold text-gray-700 mb-2">Apellidos:</label>
                            <input type="text" id="surnames" name="surnames" placeholder="Ingrese sus apellidos" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="text-left">
                            <label for="birthdate" class="block text-lg font-bold text-gray-700 mb-2">Fecha de Nacimiento:</label>
                            <input type="date" id="birthdate" name="birthdate" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <!-- Correo -->
                        <div class="text-left">
                            <label for="email" class="block text-lg font-bold text-gray-700 mb-2">Correo:</label>
                            <input type="email" id="email" name="email" placeholder="Ingrese su correo" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <!-- Teléfono -->
                        <div class="text-left">
                            <label for="phone" class="block text-lg font-bold text-gray-700 mb-2">Teléfono:</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ingrese su teléfono" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <!-- DNI -->
                        <div class="text-left">
                            <label for="dni" class="block text-lg font-bold text-gray-700 mb-2">DNI:</label>
                            <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <!-- Fecha de Cita -->
                        <div class="text-left">
                            <label for="tipo-cita" class="block text-lg font-bold text-gray-700 mb-2">Fecha de la cita:</label>
                            <select id="tipo-cita" name="tipo-cita" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="primera">Abril</option>
                                <option value="seguimiento">Mayo</option>
                            </select>
                        </div>

                        <!-- Horario de Cita -->
                        <div class="text-left">
                            <label for="tipo-cita" class="block text-lg font-bold text-gray-700 mb-2">Seleccione un horario disponible:</label>
                            <select id="tipo-cita" name="tipo-cita" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="primera">08:00</option>
                                <option value="seguimiento">09:00</option>
                            </select>
                        </div>

                        <!-- Detalles -->
                        <div class="text-left">
                            <label for="details" class="block text-lg font-bold text-gray-700 mb-2">Detalles:</label>
                            <textarea id="details" name="details" rows="4" placeholder="Escriba los detalles aquí..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                        </div>

                        <!-- Aceptar Política de Privacidad -->
                        <div class="text-left">
                            <label class="inline-flex items-center">
                                <input type="checkbox" id="privacy-policy" name="privacy-policy" required
                                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="ml-2 text-gray-700">Acepto la <a href="{{ route('privacy-policy') }}" class="text-primary hover:underline">política de privacidad</a></span>
                            </label>
                        </div>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="w-full bg-primary hover:bg-[#66a499] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out mt-6">
                        Ver Disponibilidad
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-[#66a499] text-white py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="grid grid-cols-2 gap-8 items-center sm:grid-cols-4 lg:grid-cols-7">
                <a href="https://www.ugr.es/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-ugr.svg" alt="Universidad de Granada" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.arqus-alliance.eu/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-arqus-alliance.svg" alt="Arqus European University Alliance" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.universia.net/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-universia.svg" alt="Universia" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://euraxess.ec.europa.eu/jobs/hrs4r" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-excelencia.svg" alt="HR Excellence In Research" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.aepd.es/es/pacto-digital" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-pactodigital.svg" alt="Pacto Digital para la Protección de las Personas" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.universidades.gob.es/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-transparencia-universidades.svg" alt="Universidades 2024" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.universidadespublicasdeandalucia.es/" target="_blank" rel="noopener noreferrer" class="col-span-2 sm:col-span-1 justify-self-center">
                    <img src="/assets/icons/logo-aupa.svg" alt="Universidades de Andalucía" class="w-32 h-32 mx-auto object-contain">
                </a>
            </div>
        </div>
    </footer>
    <footer class="bg-primary text-white py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row justify-between items-center">
            <div class="flex space-x-4">
                <a href="{{ route('privacy-policy') }}" class="text-sm hover:underline border-r-2 border-white pr-4">Política de privacidad</a>
                <a href="{{ route('terms-conditions') }}" class="text-sm hover:underline">Términos y condiciones</a>
            </div>
            <p class="text-sm text-center sm:text-left mb-4 sm:mb-0">© 2025 Clínica Universitaria de Visión y Optometría. Todos los derechos reservados.</p>
        </div>
    </footer>
</x-app-layout>