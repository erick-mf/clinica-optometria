<x-app-layout>
    <x-rrss />

    <!-- Sección con imagen de fondo y formulario -->
    <div class="relative py-12 bg-gray-100">
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 z-0">
            <picture>
                <source srcset="{{ asset('images/img1.webp') }}" type="image/webp">
                <img src="{{ asset('images/img1.jpg') }}" alt="Imagen de fondo" class="w-full h-full object-cover">
            </picture>
        </div>

        <!-- Contenedor del formulario con márgenes -->
        <div class="relative z-10 max-w-[1216px] mx-auto px-4 sm:px-0 my-8">
            <div class="bg-white px-6 py-4 rounded-lg shadow-lg">
                <!-- Contenido del formulario -->
                <form method="POST" action="{{ route('book-appointment.store') }}" class="space-y-4">
                    @csrf
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Reserva tu cita</h2>

                    <!-- Campos del formulario -->
                    <h3 class="text-lg font-medium text-gray-800">Datos personales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-b-2 border-primary pb-6">
                        <!-- Nombre -->
                        <div class="text-left">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre:</label>
                            <input type="text" id="name" name="name" placeholder="Ingrese su nombre"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div class="text-left">
                            <label for="surnames"
                                class="block text-sm font-medium text-gray-700 mb-1">Apellidos:</label>
                            <input type="text" id="surnames" name="surnames" placeholder="Ingrese sus apellidos"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('surnames')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="text-left">
                            <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Fecha de
                                Nacimiento:</label>
                            <input type="date" id="birthdate" name="birthdate"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('birthdate')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo -->
                        <div class="text-left">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo:</label>
                            <input type="email" id="email" name="email" placeholder="Ingrese su correo"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="text-left">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono:</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ingrese su teléfono"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DNI -->
                        <div class="text-left">
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI:</label>
                            <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('dni')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección de Citas Disponibles -->
                    <h3 class="text-lg font-medium text-gray-800 w-full">Seleccione una
                        fecha
                        y hora para su cita </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="text-left md:col-span-2 sm:grid md:grid-cols-2 gap-6">
                            <!-- Calendario de fechas disponibles -->
                            <div class="mb-4 sm:mb-0">
                                <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha
                                    de la cita:</label>
                                <div class="relative">
                                    <input type="text" id="appointment_date" name="appointment_date" readonly
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150"
                                        placeholder="Seleccione una fecha disponible">
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Solo se muestran fechas con disponibilidad</p>
                                @error('appointment_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Selector de horarios disponibles -->
                            <div>
                                <label for="appointment_time"
                                    class="block text-sm font-medium text-gray-700 mb-1">Horario
                                    disponible:</label>
                                <select id="appointment_time" name="appointment_time" disabled
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                    <option value="">Primero seleccione una fecha</option>
                                </select>
                                @error('appointment_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                <!-- Indicador de carga para disponibilidad en tiempo real -->
                                <div id="availability-status" class="text-sm text-gray-600 mt-2 hidden">
                                    <div class="flex items-center">
                                        <svg class="animate-spin h-4 w-4 mr-2 text-primary"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Verificando disponibilidad en tiempo real...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles -->
                        <div class="text-left md:col-span-2">
                            <label for="details" class="block text-sm font-medium text-gray-700 mb-1">Detalles
                                adicionales:</label>
                            <textarea id="details" name="details" rows="4" placeholder="Escribe los detalles de la cita aqui..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150"></textarea>
                            @error('details')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aceptar Política de Privacidad -->
                        <div class="text-left md:col-span-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" id="privacy-policy" name="privacy-policy"
                                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="privacy-policy" class="text-gray-700">Acepto la <a
                                            href="{{ route('privacy-policy') }}"
                                            class="text-primary hover:underline font-medium">política de
                                            privacidad</a></label>
                                </div>
                            </div>
                            @error('privacy-policy')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botón -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Reservar Cita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-footer />
    <!-- Datos de disponibilidad para JavaScript -->
    <div id="booking-data" data-available-slots="{{ json_encode($availableSlots) }}" style="display: none;"></div>
</x-app-layout>
