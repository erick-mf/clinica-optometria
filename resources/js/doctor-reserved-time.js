export function initDoctorReservedTime() {
    const datePickerElement = document.getElementById('date');
    const startTimePicker = document.getElementById('start_time');
    const endTimePicker = document.getElementById('end_time');
    const reservedHoursDisplay = document.getElementById('reserved-hours-display');
    const token = document.querySelector('meta[name="x-appointment-token"]')?.content;

    // Estado de la aplicación
    const state = {
        reservedSlots: [],
        selectedDate: null,
        startTime: null,
        endTime: null
    };

    // Inicialización de componentes
    initDatePicker();
    initTimePickers();
    setupEventListeners();

    function initDatePicker() {
        if (!datePickerElement) return;

        datePickerElement.value = "";
        flatpickr(datePickerElement, {
            locale: "es",
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            onChange: async function(selectedDates, dateStr) {
                state.selectedDate = dateStr;
                clearTimePickers();
                await fetchAndDisplayReservedHours(dateStr);
            }
        });
    }

    function initTimePickers() {
        if (!startTimePicker || !endTimePicker) return;

        // Establecer valores por defecto
        startTimePicker.value = '';
        endTimePicker.value = '';

        startTimePicker.classList.add('w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded-md');
        endTimePicker.classList.add('w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded-md');
    }

    function setupEventListeners() {
        if (startTimePicker) {
            startTimePicker.addEventListener('change', function() {
                state.startTime = this.value;
                if (state.endTime) validateTimeRange();
            });
        }

        if (endTimePicker) {
            endTimePicker.addEventListener('change', function() {
                state.endTime = this.value;
                validateTimeRange();
            });
        }
    }

    // Validar el rango de horas seleccionado
    function validateTimeRange() {
        if (!state.startTime || !state.endTime) return true;

        // Convertir a minutos para comparación
        const startMinutes = convertTimeToMinutes(state.startTime);
        const endMinutes = convertTimeToMinutes(state.endTime);

        // Verificar que la hora de fin sea posterior a la de inicio
        if (startMinutes >= endMinutes) {
            window.Toast.warning('La hora de fin debe ser posterior a la de inicio');
            endTimePicker.value = '';
            state.endTime = null;
            return false;
        }

        // Verificar colisión con horarios ocupados
        const colision = checkTimeConflicts(state.startTime, state.endTime);
        if (colision) {
            window.Toast.warning('Las horas seleccionadas colisionan con horarios ocupados');
            startTimePicker.value = '';
            endTimePicker.value = '';
            state.startTime = null;
            state.endTime = null;
            return false;
        }

        return true;
    }

    function convertTimeToMinutes(time) {
        const [hours, minutes] = time.split(':').map(Number);
        return hours * 60 + minutes;
    }

    // Verifica si hay colisión con horarios ocupados
    function checkTimeConflicts(start, end) {
        return state.reservedSlots.some(slot => {
            const slotStart = convertTimeToMinutes(slot.start_time);
            const slotEnd = convertTimeToMinutes(slot.end_time);
            const selectedStart = convertTimeToMinutes(start);
            const selectedEnd = convertTimeToMinutes(end);

            return (selectedStart >= slotStart && selectedStart < slotEnd) ||
                   (selectedEnd > slotStart && selectedEnd <= slotEnd) ||
                   (selectedStart <= slotStart && selectedEnd >= slotEnd);
        });
    }

    // Limpiar los time pickers
    function clearTimePickers() {
        if (startTimePicker) {
            startTimePicker.value = '';
            state.startTime = null;
        }
        if (endTimePicker) {
            endTimePicker.value = '';
            state.endTime = null;
        }
    }

    // Obtiene y muestra los horarios reservados para la fecha seleccionada
    async function fetchAndDisplayReservedHours(dateStr) {
        if (!reservedHoursDisplay) return;

        try {
            // Mostrar loading
            reservedHoursDisplay.innerHTML = `
                <div class="text-center py-2">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm text-gray-600">Cargando horarios...</span>
                </div>`;

            // Realizar petición al servidor
            const response = await fetch(`/api/available-slots/${dateStr}`, {
                method: "GET",
                headers: {
                    "X-Appointment-Token": token || "",
                    "Accept": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            // Actualizar el estado con los datos recibidos
            state.reservedSlots = await response.json();

            // Mostrar los horarios ocupados
            displayReservedHours();

        } catch (error) {
            console.error("Error al cargar horarios:", error);
            reservedHoursDisplay.innerHTML = `
                <div class="p-3 bg-red-50 border border-red-200 rounded-md">
                    <p class="text-sm text-red-600">
                        <span class="font-medium">Error:</span> No se pudieron cargar los horarios.
                        <button class="underline text-red-700 hover:text-red-800"
                            onclick="document.getElementById('date')._flatpickr.setDate('${dateStr}', true)">
                            Reintentar
                        </button>
                    </p>
                </div>`;
            state.reservedSlots = [];
        }
    }

    // Muestra los horarios ocupados
    function displayReservedHours() {
        if (!reservedHoursDisplay) return;

        if (state.reservedSlots.length === 0) {
            reservedHoursDisplay.innerHTML = `
                <div class="p-3 bg-green-50 border border-green-200 rounded-md">
                    <p class="text-sm text-green-600 font-medium">
                        No hay horarios reservados para esta fecha.
                    </p>
                </div>`;
            return;
        }

        let html = `
            <div class="mb-3">
                <h3 class="text-sm font-medium text-gray-700 mb-2">
                    Horarios ocupados:
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">`;

        // Cada horario ocupado
        state.reservedSlots.forEach(slot => {
            html += `
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-md p-2 text-xs sm:text-sm font-medium flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>${slot.start_time} - ${slot.end_time}</span>
                </div>`;
        });

        html += `</div>
            <div class="mt-2 text-xs text-gray-600">
                Seleccione un horario que no coincida con los bloques ocupados.
            </div>
        </div>`;

        reservedHoursDisplay.innerHTML = html;
    }
}
