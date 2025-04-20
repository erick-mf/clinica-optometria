class Toast {
    static show(type, message, duration = 3500) {
        const container = document.getElementById("toast-container") || this.createContainer();
        const toast = this.createToast(type, message);

        container.appendChild(toast);

        // Forzar reflow para activar la transición
        void toast.offsetWidth;
        toast.classList.add("show");

        // Auto cerrar después de la duración
        if (duration) {
            setTimeout(() => {
                this.removeToast(toast);
            }, duration);
        }
    }

    static createContainer() {
        const container = document.createElement("div");
        container.id = "toast-container";
        container.className = "toast-container";
        document.body.appendChild(container);
        return container;
    }

    static createToast(type, message) {
        const toast = document.createElement("div");
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span class="toast-message">${message}</span>
            <button class="toast-close">&times;</button>
        `;

        // Evento para cerrar manualmente
        toast.querySelector(".toast-close").addEventListener("click", () => {
            this.removeToast(toast);
        });

        return toast;
    }

    static removeToast(toast) {
        toast.classList.remove("show");
        setTimeout(() => {
            toast.remove();
        }, 300);
    }

    static success(message, duration) {
        this.show("success", message, duration);
    }

    static error(message, duration) {
        this.show("error", message, duration);
    }

    static info(message, duration) {
        this.show("info", message, duration);
    }

    static warning(message, duration) {
        this.show("warning", message, duration);
    }
}

// Hacer disponible globalmente
window.Toast = Toast;

// Manejar toasts desde session (PHP)
document.addEventListener("DOMContentLoaded", () => {
    if (window.toastData) {
        Toast.show(window.toastData.type, window.toastData.message);
    }
});
