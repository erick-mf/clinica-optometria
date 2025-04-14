document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("appointment_date");
    const timeSelect = document.getElementById("appointment_time");
    const statusElement = document.getElementById("availability-status");
    const token = document.querySelector('meta[name="x-appointment-token"]').getAttribute("content");
    // Verificar que los elementos existen
    if (!dateInput || !timeSelect) return;

    // Obtener datos de disponibilidad
    const bookingData = document.getElementById("booking-data");
    const availableSlots = bookingData ? JSON.parse(bookingData.dataset.availableSlots || "{}") : {};

    // Configurar Flatpickr
    const fp = flatpickr(dateInput, {
        locale: "es",
        minDate: "today",
        enable: Object.keys(availableSlots),
        dateFormat: "Y-m-d",
        onChange: function (selectedDates, dateStr) {
            updateTimeSlots(dateStr, availableSlots);
            checkRealTimeAvailability(dateStr);
        },
    });

    // Función para actualizar los horarios disponibles
    function updateTimeSlots(date, slotsData) {
        timeSelect.innerHTML = "";
        if (!date || !slotsData[date] || slotsData[date].length === 0) {
            timeSelect.innerHTML = '<option value="">No hay horarios disponibles para esta fecha</option>';
            timeSelect.disabled = true;
            return;
        }

        // Filtrar solo slots disponibles
        const availableSlots = slotsData[date].filter((slot) => slot.available);

        // Agregar opción por defecto
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "Seleccione un horario";
        timeSelect.appendChild(defaultOption);

        // Ordenar slots por hora y mostrar solo disponibles
        const sortedSlots = [...availableSlots].sort((a, b) => a.start_time.localeCompare(b.start_time));

        // Crear opciones para cada slot disponible
        sortedSlots.forEach((slot) => {
            const option = document.createElement("option");
            option.value = slot.id;
            option.textContent = `${formatTime(slot.start_time)} - ${formatTime(slot.end_time)}`;
            timeSelect.appendChild(option);
        });

        timeSelect.disabled = false;

        // Si no hay opciones disponibles, mostrar mensaje
        if (sortedSlots.length === 0) {
            timeSelect.innerHTML = '<option value="">No hay horarios disponibles para esta fecha</option>';
            timeSelect.disabled = true;
        }
    }

    // Función para formatear hora (eliminar segundos)
    function formatTime(timeString) {
        if (!timeString) return "";
        const parts = timeString.split(":");
        return `${parts[0]}:${parts[1]}`;
    }

    // Función para verificar disponibilidad en tiempo real
    async function checkRealTimeAvailability(date) {
        try {
            statusElement.classList.remove("hidden");

            const response = await fetch(`/api/available-slots/${date}`, {
                method: "GET",
                headers: {
                    "X-Appointment-Token": token,
                },
            });
            if (!response.ok) throw new Error("Error en la respuesta");

            const updatedSlots = await response.json();

            // Actualizar datos locales
            availableSlots[date] = updatedSlots;

            // Actualizar selector
            updateTimeSlots(date, {
                [date]: updatedSlots,
            });
        } catch (error) {
            console.error("Error al verificar disponibilidad:", error);
            timeSelect.innerHTML = '<option value="">Error al cargar horarios. Intente nuevamente.</option>';
            timeSelect.disabled = true;
        } finally {
            statusElement.classList.add("hidden");
        }
    }

    // Inicializar el selector de horarios
    timeSelect.innerHTML = '<option value="">Primero seleccione una fecha</option>';
    timeSelect.disabled = true;
});
