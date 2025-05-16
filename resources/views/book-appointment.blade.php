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

                    <!-- Sección de datos del paciente -->
                    <div class="space-y-6 mb-6 border-b-2 border-primary pb-6">
                        <h3 class="text-base sm:text-lg lg:text-xl font-medium text-gray-800">
                            Datos del paciente
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Nombre -->
                            <div class="text-left">
                                <label for="name"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nombre *</label>
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
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Apellidos
                                    *</label>
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
                                    Nacimiento *</label>
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
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Correo</label>
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
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Teléfono *</label>
                                <input type="tel" id="phone" name="phone" placeholder="Ingrese su teléfono"
                                    value="{{ old('phone') }}"
                                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                @error('phone')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Documento de identidad -->
                            <div class="text-left w-full">
                                <div class="flex flex-wrap sm:flex-nowrap gap-4 items-start">
                                    <div class="w-full sm:w-[40%]">
                                        <label for="document_type"
                                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Tipo de
                                            Documento</label>
                                        <select id="document_type" name="document_type"
                                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition duration-150">
                                            <option value="">Seleccionar</option>
                                            <option value="DNI"
                                                {{ old('document_type') == 'DNI' ? 'selected' : '' }}>DNI</option>
                                            <option value="NIE"
                                                {{ old('document_type') == 'NIE' ? 'selected' : '' }}>NIE</option>
                                            <option value="Pasaporte"
                                                {{ old('document_type') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte
                                            </option>
                                        </select>
                                        @error('document_type')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full sm:w-[60%]">
                                        <label for="document_number"
                                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Número de
                                            Documento</label>
                                        <input type="text" id="document_number" name="document_number"
                                            placeholder="Ingrese el número de documentación"
                                            value="{{ old('document_number') }}"
                                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                        @error('document_number')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de datos del tutor -->
                    <div class="space-y-6 mb-6 border-b-2 border-primary pb-6" id="guardian-info">
                        <h3 class="text-base sm:text-lg lg:text-xl font-medium text-gray-800">
                            Datos del tutor legal (requerido para menores de edad)
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Nombre del tutor -->
                            <div class="text-left">
                                <label for="tutor_name"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nombre del tutor
                                    *</label>
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
                                    tutor</label>
                                <input type="email" id="tutor_email" name="tutor_email"
                                    placeholder="Ingrese el correo del tutor" value="{{ old('tutor_email') }}"
                                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                @error('tutor_email')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Documento del tutor -->
                            <div class="text-left w-full">
                                <div class="flex flex-wrap sm:flex-nowrap gap-4 items-start">
                                    <div class="w-full sm:w-[40%]">
                                        <label for="tutor_document_type"
                                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Tipo de
                                            Documento</label>
                                        <select id="tutor_document_type" name="tutor_document_type"
                                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary focus:border-primary transition duration-150">
                                            <option value="">Seleccionar</option>
                                            <option value="DNI"
                                                {{ old('tutor_document_type') == 'DNI' ? 'selected' : '' }}>DNI
                                            </option>
                                            <option value="NIE"
                                                {{ old('tutor_document_type') == 'NIE' ? 'selected' : '' }}>NIE
                                            </option>
                                            <option value="Pasaporte"
                                                {{ old('tutor_document_type') == 'Pasaporte' ? 'selected' : '' }}>
                                                Pasaporte</option>
                                        </select>
                                        @error('tutor_document_type')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-full sm:w-[60%]">
                                        <label for="tutor_document_number"
                                            class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Número de
                                            Documento</label>
                                        <input type="text" id="tutor_document_number" name="tutor_document_number"
                                            placeholder="Ingrese el número de documentación"
                                            value="{{ old('tutor_document_number') }}"
                                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                        @error('tutor_document_number')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Teléfono del tutor -->
                            <div class="text-left">
                                <label for="tutor_phone"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Teléfono del
                                    tutor *</label>
                                <input type="tel" id="tutor_phone" name="tutor_phone"
                                    placeholder="Ingrese el teléfono del tutor" value="{{ old('tutor_phone') }}"
                                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                @error('tutor_phone')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sección de información de la cita -->
                    <div class="space-y-6">
                        <h3 class="text-base sm:text-lg lg:text-xl font-medium text-gray-800">
                            Información de la cita
                        </h3>

                        <!-- Tipo de cita -->
                        <div class="text-left w-full">
                            <label for="type"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Tipo de cita
                                *</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="primera cita"
                                        {{ old('type') == 'primera cita' ? 'checked' : '' }}
                                        class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                    <span class="ml-2 text-sm sm:text-base font-medium text-gray-700">Primera
                                        cita</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type" value="revision"
                                        {{ old('type') == 'revision' ? 'checked' : '' }}
                                        class="form-radio h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                    <span class="ml-2 text-sm sm:text-base font-medium text-gray-700">Revisión</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha y hora de la cita -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Fecha -->
                            <div class="text-left">
                                <label for="appointment_date"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Fecha de la cita
                                    *</label>
                                <input type="text" id="appointment_date" name="appointment_date" readonly
                                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150"
                                    placeholder="Seleccione una fecha disponible">
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Solo se muestran fechas con
                                    disponibilidad</p>
                                @error('appointment_date')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hora -->
                            <div class="text-left">
                                <label for="appointment_time"
                                    class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Horario
                                    disponible *</label>
                                <select id="appointment_time" name="appointment_time" disabled
                                    class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150">
                                    <option value="">Primero seleccione una fecha</option>
                                </select>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">Se agrupan horarios con múltiples
                                    citas disponibles</p>
                                @error('appointment_time')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Detalles adicionales -->
                        <div class="text-left">
                            <label for="details"
                                class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Detalles
                                adicionales</label>
                            <textarea id="details" name="details" rows="3" placeholder="Escribe los detalles de la cita aqui..."
                                maxlength="255"
                                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 resize-none">{{ old('details') ?? '' }}</textarea>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1"><span id="char-count">0</span>/255</p>
                            @error('details')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aceptación de política de privacidad -->
                        <div class="text-left">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" id="privacy-policy" name="privacy-policy"
                                        {{ old('privacy-policy') ? 'checked' : '' }}
                                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="privacy-policy" class="text-gray-700">Acepto la <a
                                            href="{{ route('privacy-policy') }}"
                                            class="text-primary hover:underline font-medium">política de privacidad</a>
                                        *</label>
                                </div>
                            </div>
                            @error('privacy-policy')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botón de envío -->
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
