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

    <!-- Sección de contacto -->
    <div class="location-section max-w-7xl mx-auto py-12 px-6 sm:px-8">
        <!-- Contenedor del formulario con márgenes -->
        <div class="relative z-10 max-w-md mx-auto px-4 sm:px-0 my-8">
            <div class="bg-white bg-opacity-90 p-6 rounded-lg shadow-lg">
                <!-- Contenido del formulario -->
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4" class="space-y-4">
                    @csrf
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Contáctanos:</h2>

                    <!-- Campos del formulario -->
                    <div class="space-y-4">
                        <!-- Nombre -->
                        <div class="text-left">
                            <label for="name" class="block text-lg font-bold text-gray-700 mb-2">Nombre:</label>
                            <input type="text" id="name" name="name" placeholder="Ingrese su nombre" value="{{old('name')}}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror       
                        </div>

                        <!-- Apellidos -->
                        <div class="text-left">
                            <label for="surnames" class="block text-lg font-bold text-gray-700 mb-2">Apellidos:</label>
                            <input type="text" id="surnames" name="surnames" placeholder="Ingrese sus apellidos" value="{{old('surnames')}}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('surnames')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror 
                        </div>

                        <!-- Selección entre Teléfono o Correo -->
                        <div class="text-left">
                            <label for="contact_method" class="block text-lg font-bold text-gray-700 mb-2">Método de contacto:</label>
                            <select id="contact_method" name="contact_method" value="{{old('contact_method')}}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="phone">Teléfono</option>
                                <option value="email">Correo</option>
                            </select>
                            @error('contact_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror 
                        </div>

                        <!-- Campo Teléfono -->
                        <div id="phone-field" class="text-left hidden">
                            <label for="phone" class="block text-lg font-bold text-gray-700 mb-2">Teléfono:</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ingrese su teléfono" value="{{old('phone')}}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror      
                        </div>

                        <!-- Campo Correo -->
                        <div id="email-field" class="text-left hidden">
                            <label for="email" class="block text-lg font-bold text-gray-700 mb-2">Correo:</label>
                            <input type="email" id="email" name="email" placeholder="Ingrese su correo" value="{{old('email')}}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror  
                        </div>

                        <!-- Mensaje -->
                        <div class="text-left">
                            <label for="content_message" class="block text-lg font-bold text-gray-700 mb-2">Mensaje:</label>
                            <textarea id="content_message" name="content_message" rows="4" placeholder="Escriba los detalles aquí..." value="{{old('content_message')}}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                            @error('content_message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror      
                        </div>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="w-full bg-primary hover:bg-[#66a499] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Enviar
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactMethod = document.getElementById('contact_method');
            const phoneField = document.getElementById('phone-field');
            const emailField = document.getElementById('email-field');

            contactMethod.addEventListener('change', function () {
                if (this.value === 'phone') {
                    phoneField.classList.remove('hidden');
                    emailField.classList.add('hidden');
                } else if (this.value === 'email') {
                    emailField.classList.remove('hidden');
                    phoneField.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>