export function updateDoctorOffice() {
    const statusRadios = document.querySelectorAll('input[name="status"]');

    if (statusRadios.length > 0) {
        statusRadios.forEach(function(radio) {
            radio.addEventListener('change', handleDoctorSection);
        });
    }

    handleDoctorSection();
}

function handleDoctorSection() {
    const doctorSection = document.getElementById('doctor_assignment_section');
    const statusActivo = document.getElementById('status_activo');
    const isActive = statusActivo ? statusActivo.checked : false;

    if (!doctorSection) return;

    if (isActive) {
        doctorSection.classList.remove('hidden');
    } else {
        doctorSection.classList.add('hidden');
        const userIdSelect = document.getElementById('user_id');
        if (userIdSelect) {
            userIdSelect.value = '';
        }
    }
}
