import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js";
import "flatpickr/dist/flatpickr.min.css";
import "flatpickr/dist/themes/material_green.css";

window.flatpickr = flatpickr;
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

// Manejo de turnos - Solo añadí clases responsive
const setupTurnManagement = () => {
    let turnIndex = 1;
    const addTurnButton = document.getElementById("add-turn");
    const turnsWrapper = document.getElementById("turns-wrapper");

    if (!addTurnButton || !turnsWrapper) return;

    addTurnButton.addEventListener("click", () => {
        const div = document.createElement("div");
        div.className = "flex flex-col sm:flex-row gap-4 items-start sm:items-end"; // Clases responsive añadidas
        div.innerHTML = `
            <div class="w-full sm:flex-1 min-w-[120px]">
                <label class="block text-sm text-gray-700 mb-1">Hora inicio</label>
                <input type="time" name="turns[${turnIndex}][start]" class="w-full px-3 py-2 border border-gray-300 rounded" required>
            </div>
            <div class="w-full sm:flex-1 min-w-[120px]">
                <label class="block text-sm text-gray-700 mb-1">Hora fin</label>
                <input type="time" name="turns[${turnIndex}][end]" class="w-full px-3 py-2 border border-gray-300 rounded" required>
            </div>
            <button type="button" class="remove-turn w-full sm:w-auto px-3 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 mt-0 sm:mt-[1.625rem]">
                Eliminar
            </button>
        `;
        turnsWrapper.appendChild(div);
        turnIndex++;
    });

    turnsWrapper.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-turn")) {
            const turns = document.querySelectorAll("#turns-wrapper > div");
            if (turns.length > 1) {
                e.target.closest("div.flex").remove();
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
