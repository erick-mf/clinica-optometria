export function modal() {
    // Referencias al modal de eliminación
    const deleteModal = document.getElementById("deleteModal");
    const cancelDelete = document.getElementById("cancelDelete");
    const confirmDelete = document.getElementById("confirmDelete");

    if (!deleteModal || !cancelDelete || !confirmDelete) {
        // Para evitar los errores de referencia cuando se llama a la función sin los elementos cargados
        return;
    }

    let currentDeleteForm = null;

    // Función para mostrar el modal de confirmación de eliminación
    function showDeleteModal(form) {
        currentDeleteForm = form;
        deleteModal.classList.remove("hidden");
        deleteModal.classList.add("flex");
    }

    // Configurar eventos para botones de eliminación
    document.querySelectorAll(".delete-button").forEach((button) => {
        button.addEventListener("click", function () {
            const formContainer = this.closest("[data-container='modal']");
            if (formContainer) {
                currentDeleteForm = formContainer.querySelector(".delete-form");
                if (currentDeleteForm) {
                    deleteModal.classList.remove("hidden");
                }
            }
        });
    });

    document.querySelectorAll(".delete-button-mobile").forEach((button) => {
        button.addEventListener("click", function () {
            showDeleteModal(this.nextElementSibling);
        });
    });

    // Configurar eventos para el modal de eliminación
    cancelDelete.addEventListener("click", function () {
        deleteModal.classList.add("hidden");
        deleteModal.classList.remove("flex");
        currentDeleteForm = null;
    });

    confirmDelete.addEventListener("click", function () {
        if (currentDeleteForm) {
            currentDeleteForm.submit();
        }
    });

    // Manejar escape para cerrar el modal
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && !deleteModal.classList.contains("hidden")) {
            deleteModal.classList.add("hidden");
            deleteModal.classList.remove("flex");
            currentDeleteForm = null;
        }
    });

    // Cerrar el modal al hacer clic fuera de él
    deleteModal.addEventListener("click", function (e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add("hidden");
            deleteModal.classList.remove("flex");
            currentDeleteForm = null;
        }
    });
}
