<x-app-layout>
    <x-rrss />

    <!-- Sección con imagen de fondo y formulario -->
    <div class="relative py-8 sm:py-12 lg:py-16 bg-gray-100">
        <!-- Imagen de fondo -->
        <div class="absolute inset-0 z-0">
            <picture>
                <source srcset="{{ asset('images/img1.webp') }}" type="image/webp">
                <img src="{{ asset('images/img1.jpg') }}" alt="Imagen de fondo" class="w-full h-full object-cover">
            </picture>
        </div>

        <!-- Contenedor del formulario-->
        <div class="relative z-10 max-w-[1216px] mx-auto px-4 sm:px-6 lg:px-8 my-4 md:my-8 lg:my-12">
            <div class="bg-white px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10 rounded-lg shadow-lg">
                <form method="POST" action="{{ route('book-appointment.store') }}" class="space-y-4 md:space-y-6">
                    @csrf
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 text-center">
                        Reserva tu cita
                    </h2>

                    <!-- Campos del formulario -->
                    <h3 class="text-base sm:text-lg lg:text-xl font-medium text-gray-800">
                        Datos personales
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6 border-b-2 border-primary pb-6">
                        <!-- Nombre -->
                        <div class="text-left">
                            <label for="name"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nombre:</label>
                            <input type="text" id="name" name="name" placeholder="Ingrese su nombre"
                                value="{{ old('name') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('name')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div class="text-left">
                            <label for="surnames"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Apellidos:</label>
                            <input type="text" id="surnames" name="surnames" placeholder="Ingrese sus apellidos"
                                value="{{ old('surnames') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('surnames')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="text-left">
                            <label for="birthdate"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Fecha de
                                Nacimiento:</label>
                            <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}"
                                min="{{ \Carbon\Carbon::now()->subYears(100)->format('Y-m-d') }}"
                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('birthdate')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo -->
                        <div class="text-left">
                            <label for="email"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Correo:</label>
                            <input type="email" id="email" name="email" placeholder="Ingrese su correo"
                                value="{{ old('email') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('email')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="text-left">
                            <label for="phone"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Teléfono:</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ingrese su teléfono"
                                value="{{ old('phone') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('phone')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DNI -->
                        <div class="text-left">
                            <label for="dni"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">DNI/NIE:</label>
                            <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI/NIE"
                                value="{{ old('dni') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('dni')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección de información del tutor para menores de edad -->
                    <div id="guardian-info"
                        class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6 border-b-2 border-primary pb-6">
                        <h3 class="text-base sm:text-lg lg:text-xl font-medium text-gray-800 md:col-span-2">
                            Datos del tutor legal (requerido para menores de edad)
                        </h3>

                        <!-- Nombre del tutor -->
                        <div class="text-left">
                            <label for="tutor_name"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nombre del
                                tutor:</label>
                            <input type="text" id="tutor_name" name="tutor_name"
                                placeholder="Ingrese el nombre del tutor" value="{{ old('tutor_name') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('tutor_name')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo del tutor -->
                        <div class="text-left">
                            <label for="tutor_email"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Correo del
                                tutor:</label>
                            <input type="email" id="tutor_email" name="tutor_email"
                                placeholder="Ingrese el correo del tutor" value="{{ old('tutor_email') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('tutor_email')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DNI del tutor -->
                        <div class="text-left">
                            <label for="tutor_dni"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">DNI/NIE del
                                tutor:</label>
                            <input type="text" id="tutor_dni" name="tutor_dni"
                                placeholder="Ingrese el DNI/NIE del tutor" value="{{ old('tutor_dni') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('tutor_dni')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono del tutor -->
                        <div class="text-left">
                            <label for="tutor_phone"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Teléfono del
                                tutor:</label>
                            <input type="tel" id="tutor_phone" name="tutor_phone"
                                placeholder="Ingrese el teléfono del tutor" value="{{ old('tutor_phone') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                            @error('tutor_phone')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección de Citas Disponibles -->
                    <h3 class="text-base sm:text-lg lg:text-xl font-medium text-gray-800 w-full">
                        Sección de Citas Disponibles
                    </h3>

                    <!-- Tipo de cita -->
                    <div class="text-left w-full">
                        <label for="type" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Tipo
                            de
                            cita:</label>

                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="type" value="primera cita"
                                    class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                <span class="ml-2 text-sm sm:text-base font-medium text-gray-700">Primera cita</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="type" value="revision"
                                    class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                <span class="ml-2 text-sm sm:text-base font-medium text-gray-700">Revisión</span>
                            </label>
                        </div>

                        @error('type')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Calendario y horarios -->
                        <div class="md:col-span-2 space-y-4 sm:space-y-0 sm:grid md:grid-cols-2 gap-6">
                            <!-- Calendario -->
                            <div class="mb-4 sm:mb-0">
                                <label for="appointment_date"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Fecha de la
                                    cita:</label>
                                <div class="relative">
                                    <input type="text" id="appointment_date" name="appointment_date" readonly
                                        class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150"
                                        placeholder="Seleccione una fecha disponible">
                                </div>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Solo se muestran fechas con
                                    disponibilidad</p>
                                @error('appointment_date')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Horarios -->
                            <div>
                                <label for="appointment_time"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Horario
                                    disponible:</label>
                                <select id="appointment_time" name="appointment_time" disabled
                                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                    <option value="">Primero seleccione una fecha</option>
                                </select>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Se agrupan horarios con múltiples
                                    citas disponibles</p>
                                @error('appointment_time')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <!-- Indicador de carga -->
                                <div id="availability-status" class="text-xs sm:text-sm text-gray-600 mt-2 hidden">
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
                            <label for="details"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Detalles
                                adicionales:</label>
                            <textarea id="details" name="details" rows="3" placeholder="Escribe los detalles de la cita aqui..."
                                maxlength="255" value="{{ old('details') }}"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 resize-none"></textarea>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1"><span id="char-count">0</span>/255</p>
                            @error('details')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Checkbox -->
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
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full px-4 py-2 sm:px-6 sm:py-3 lg:px-8 lg:py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Reservar Cita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-footer />
    <div id="booking-data" data-available-slots="{{ json_encode($availableSlots) }}" style="display: none;"></div>
</x-app-layout>
