import "./bootstrap";
import Alpine from "alpinejs";
import { modal } from "./modal";
import { flatpickrInit } from "./datepicker";
import { initDoctorReservedTime } from "./doctor-reserved-time";
import { charCount } from "./char-count";
import { updateDoctorOffice } from "./update-doctor-office";
import "./book-appointment";
import "./toast";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    modal();
    flatpickrInit();
    initDoctorReservedTime();
    charCount();
    updateDoctorOffice();
});

