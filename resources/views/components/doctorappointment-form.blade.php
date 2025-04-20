@props(['patient', 'doctor', 'schedules', 'action', 'availableSlots', 'isEdit' => false])

<form method="POST" action="{{ $action }} " class="space-y-4 md:space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif
    <!-- Datos para la cita -->
    <input type="hidden" name="doctor_id" value="{{ $doctor }}">
    <input type="hidden" name="patient_id" value="{{ $patient }}">
    <!-- Tipo de cita -->
    <div class="text-left w-full">
        <label for="type" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Tipo de
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
                <label for="appointment_date" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Fecha de
                    la
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
                <label for="appointment_time" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Horario
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
                        <svg class="animate-spin h-4 w-4 mr-2 text-primary" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
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
            <label for="details" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Detalles
                adicionales:</label>
            <textarea id="details" name="details" rows="3" placeholder="Escribe los detalles de la cita aqui..."
                maxlength="255"
                class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 resize-none"></textarea>
            <p class="text-xs sm:text-sm text-gray-500 mt-1"><span id="char-count">0</span>/255</p>
            @error('details')
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

<!-- Datos de disponibilidad para JavaScript -->
<div id="booking-data" data-available-slots="{{ json_encode($availableSlots) }}" style="display: none;"></div>
