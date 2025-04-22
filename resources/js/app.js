import "./bootstrap";
import Alpine from "alpinejs";
import { modal } from "./modal";
import { flatpickrInit } from "./datepicker";
import "./book-appointment";
import "./toast";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    modal();
    flatpickrInit();

    const textarea = document.getElementById("details");
    const charCount = document.getElementById("char-count");

    if (!textarea || !charCount) return;

    function updateCharCount() {
        const count = textarea.value.length;
        charCount.textContent = count;
    }

    textarea.addEventListener("input", updateCharCount);
    updateCharCount();
});
