<x-app-layout>
    <x-rrss />

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
                            <input type="text" id="name" name="name" placeholder="Ingrese su nombre"
                                value="{{ old('name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div class="text-left">
                            <label for="surnames" class="block text-lg font-bold text-gray-700 mb-2">Apellidos:</label>
                            <input type="text" id="surnames" name="surnames" placeholder="Ingrese sus apellidos"
                                value="{{ old('surnames') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('surnames')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Selección entre Teléfono o Correo -->
                        <div class="text-left">
                            <label for="contact_method" class="block text-lg font-bold text-gray-700 mb-2">Método de
                                contacto:</label>
                            <select id="contact_method" name="contact_method" value="{{ old('contact_method') }}"
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
                            <input type="tel" id="phone" name="phone" placeholder="Ingrese su teléfono"
                                value="{{ old('phone') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo Correo -->
                        <div id="email-field" class="text-left hidden">
                            <label for="email" class="block text-lg font-bold text-gray-700 mb-2">Correo:</label>
                            <input type="email" id="email" name="email" placeholder="Ingrese su correo"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mensaje -->
                        <div class="text-left">
                            <label for="details" class="block text-lg font-bold text-gray-700 mb-2">Mensaje:</label>
                            <textarea id="details" name="details" rows="4" placeholder="Escriba los detalles aquí..."
                                value="{{ old('details') }}" maxlength="255"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary resize-none"></textarea>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1"><span id="char-count">0</span>/255</p>
                            @error('details')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botón -->
                    <button type="submit"
                        class="w-full bg-primary hover:bg-[#66a499] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactMethod = document.getElementById('contact_method');
            const phoneField = document.getElementById('phone-field');
            const emailField = document.getElementById('email-field');

            contactMethod.addEventListener('change', function() {
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
