import "./bootstrap";
import Alpine from "alpinejs";
import { modal } from "./modal";
import { flatpickrInit } from "./datepicker";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    modal();
    flatpickrInit();

    const filterMonth = document.getElementById("filterMonth");

    // Función para filtrar horarios por mes
    function filterSchedules() {
        const monthFilter = filterMonth.value;

        // Para vista móvil (tarjetas)
        const cards = document.querySelectorAll(".schedule-card");
        cards.forEach((card) => {
            const dateText = card.querySelector(".font-semibold").textContent.trim(); // Fecha en formato "d/m/Y"
            const dateObject = convertToDate(dateText); // Convertir a objeto Date
            if (!dateObject) return; // Si la fecha es inválida, omitir esta tarjeta

            const month = dateObject.getMonth() + 1; // Obtener el mes (1-12)

            // Mostrar u ocultar tarjeta según el filtro
            card.style.display = monthFilter === "" || month.toString() === monthFilter ? "block" : "none";
        });

        // Para vista de escritorio (filas de tabla)
        const rows = document.querySelectorAll(".schedule-row");
        rows.forEach((row) => {
            const dateText = row.querySelector(".font-medium").textContent.trim(); // Fecha en formato "d/m/Y"
            const dateObject = convertToDate(dateText); // Convertir a objeto Date
            if (!dateObject) return; // Si la fecha es inválida, omitir esta fila

            const month = dateObject.getMonth() + 1; // Obtener el mes (1-12)

            // Mostrar u ocultar fila según el filtro
            row.style.display = monthFilter === "" || month.toString() === monthFilter ? "table-row" : "none";
        });
    }

    // Función auxiliar para convertir una fecha en formato "d/m/Y" a un objeto Date
    function convertToDate(dateText) {
        const [day, month, year] = dateText.split("/").map(Number); // Dividir la fecha en día, mes y año
        if (isNaN(day) || isNaN(month) || isNaN(year)) return null; // Validar que los valores sean números
        return new Date(year, month - 1, day); // Crear un objeto Date
    }

    // Evento para aplicar el filtro cuando cambia el mes seleccionado
    filterMonth.addEventListener("change", filterSchedules);
});
