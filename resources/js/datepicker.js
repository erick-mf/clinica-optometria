import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js";
import "flatpickr/dist/flatpickr.min.css";
import "flatpickr/dist/themes/material_green.css";

window.flatpickr = flatpickr;
flatpickr.localize(Spanish);

// Función para formatear fecha como YYYY-MM-DD
const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
};

// Configuración de flatpickr
const setupDatePickers = (disabledDates) => {
    const commonOptions = {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: [
            function (date) {
                const formattedDate = formatDate(date);
                return disabledDates.includes(formattedDate);
            },
        ],
        locale: {
            firstDayOfWeek: 1,
            ...Spanish,
        },
        theme: "material_green",
    };

    // Datepicker de inicio
    const startDatePicker = flatpickr("#start_date_picker", {
        ...commonOptions,
        onChange: function (selectedDates, dateStr) {
            document.getElementById("start_date").value = selectedDates.length ? dateStr : "";
            if (selectedDates.length > 0) {
                endDatePicker.set("minDate", selectedDates[0]);
            }
        },
    });

    // Datepicker de fin
    const endDatePicker = flatpickr("#end_date_picker", {
        ...commonOptions,
        onChange: function (selectedDates, dateStr) {
            document.getElementById("end_date").value = selectedDates.length ? dateStr : "";
        },
    });

    return { startDatePicker, endDatePicker };
};

// Manejo de turnos con selección múltiple de doctores
const setupTurnManagement = () => {
    const appData = document.getElementById("app-data");
    const doctors = appData ? JSON.parse(appData.dataset.doctors) : [];

    let turnCounter = document.querySelectorAll(".turn-group").length;
    const addTurnButton = document.getElementById("add-turn");
    const turnsWrapper = document.getElementById("turns-wrapper");

    if (!addTurnButton || !turnsWrapper) return;

    // Función para crear checkboxes de doctores
    const createDoctorCheckboxes = (turnIndex) => {
        let checkboxesHTML = "";
        doctors.forEach((doctor) => {
            checkboxesHTML += `
                <div class="flex items-center">
                    <input type="checkbox" id="turn-${turnIndex}-doctor-${doctor.id}"
                        name="turns[${turnIndex}][doctors][]"
                        value="${doctor.id}"
                        class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                    <label for="turn-${turnIndex}-doctor-${doctor.id}" class="ml-2 text-sm text-gray-700">
                        ${doctor.name}
                    </label>
                </div>
            `;
        });
        return checkboxesHTML;
    };

    // Añadir nuevo turno
    addTurnButton.addEventListener("click", () => {
        const newTurnGroup = document.createElement("div");
        newTurnGroup.className = "turn-group flex flex-col gap-4 p-4 border border-gray-200 rounded-lg";

        newTurnGroup.innerHTML = `
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Hora inicio</label>
                    <input type="time" name="turns[${turnCounter}][start]"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Hora fin</label>
                    <input type="time" name="turns[${turnCounter}][end]"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Doctores para este turno</label>
                <div class="space-y-2 max-h-60 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                    ${createDoctorCheckboxes(turnCounter)}
                </div>
                <p class="text-xs text-gray-500 mt-1">Selecciona uno o varios doctores</p>
            </div>

            <button type="button"
                class="remove-turn w-full sm:w-auto px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                Eliminar turno
            </button>
        `;

        turnsWrapper.appendChild(newTurnGroup);
        turnCounter++;
    });

    // Eliminar turno
    turnsWrapper.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-turn")) {
            const turnGroups = document.querySelectorAll(".turn-group");
            if (turnGroups.length > 1) {
                e.target.closest(".turn-group").remove();
            } else {
                // Usando tu toast personalizado
                if (window.Toast) {
                    window.Toast.info("Para eliminar un turno, primero debes añadir uno nuevo.");
                } else {
                    console.warn("Toast library not found, falling back to alert");
                    alert("Para eliminar un turno, primero debes añadir uno nuevo.");
                }
            }
        }
    });
};

export function flatpickrInit() {
    // Obtener datos de PHP desde el elemento en el DOM
    const appData = document.getElementById("app-data");
    const disabledDates = appData ? JSON.parse(appData.dataset.disabledDates) : [];

    // Inicializar componentes
    setupDatePickers(disabledDates);
    setupTurnManagement();
}
