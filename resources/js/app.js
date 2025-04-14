import "./bootstrap";
import Alpine from "alpinejs";
import { modal } from "./modal";
import { flatpickrInit } from "./datepicker";
import "./book-appointment";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    modal();
    flatpickrInit();
});
