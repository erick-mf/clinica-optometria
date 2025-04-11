<x-app-layout>
    <!-- Sección de redes sociales -->
    <div class="bg-gray-800 py-2">
        <div class="max-w-7xl mx-auto flex items-center justify-start space-x-4 px-4 sm:px-6">
            <h3 class="text-xl font-bold text-white">Síguenos en redes sociales</h3>
            <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer">
                <img src="/assets/icons/facebook.svg" alt="Facebook" class="w-6 h-6 object-contain">
            </a>
            <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer">
                <img src="/assets/icons/instagram.svg" alt="Instagram" class="w-6 h-6 object-contain">
            </a>
            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
                <img src="/assets/icons/twitter.svg" alt="Twitter" class="w-6 h-6 object-contain">
            </a>
        </div>
    </div>

    <!-- Sección con imagen de fondo y formulario -->
    <div class="hero-section relative h-[38rem] bg-cover bg-center" style="background-image: url('/images/img5.webp');">
        <div class="absolute top-1/4 right-4 sm:right-20 bg-white bg-opacity-90 p-6 rounded-lg shadow-lg w-11/12 sm:w-80 text-center">
            <form action="{{ route('book-appointment') }}" method="GET">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Pida su cita</h2>
                <br>
                <label for="tipo-cita" class="block text-lg font-bold text-gray-700 mb-2 text-left">Tipo de cita:</label>
                <select id="tipo-cita" name="tipo-cita" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-primary mb-4">
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="primera">Primera cita</option>
                    <option value="seguimiento">Revisión</option>
                </select>
                <button type="submit" class="w-full bg-primary hover:bg-[#66a499] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Ver Disponibilidad
                </button>
            </form>
        </div>
    </div>

    <!-- Sección con mapa y texto -->
    <div class="location-section max-w-7xl mx-auto py-12 px-6 sm:px-8">
        <h3 class="text-2xl font-bold text-gray-800 text-center mb-8">¿Dónde encontrarnos?</h3>
        <div class="flex flex-col sm:flex-row items-center gap-8">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3178.805430064723!2d-3.6053723886933993!3d37.18109467202474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71fcea8c8d04d7%3A0xbcd461fa8bdad6b6!2sHospital%20San%20Rafael!5e0!3m2!1ses!2ses!4v1712148575847!5m2!1ses!2ses" 
                class="w-full sm:w-1/2 h-64 sm:h-80 rounded-lg shadow-md" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="info-text w-full sm:w-1/2">
                <p class="text-gray-800 font-bold mb-4">Hospital San Rafael, C/ San Juan de Dios, 19, Centro, 18001 Granada.</p>
                <ul class="list-disc list-inside text-gray-600">
                    <li>1º Periodo: Octubre - Noviembre</li>
                    <li>2º Periodo: Marzo - Abril</li>
                    <li>3º Periodo: Abril - Junio</li>
                </ul>
                <br>
                <p class="text-gray-800 font-bold mb-4">Nuestros Horarios (Aproximados):</p>
                <ul class="list-disc list-inside text-gray-600">
                    <li>Lunes, Miércoles, Jueves, Viernes de 08:00 a 13:30 h</li>
                    <li>Lunes a Jueves de 15:00 h a 20:30 h</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Sección de contacto -->
    <div class="max-w-7xl mx-auto py-12 px-6 sm:px-8">
        <h3 class="text-2xl font-bold text-gray-800 text-center mb-8">¿Quieres ponerte en contacto con nosotros?</h3>
        <p class="text-gray-600 text-center mb-4 mx-auto max-w-3xl">
            Si desea comunicarse con nosotros por dudas, sugerencias, quejas o cualquier otro motivo, 
            puede hacerlo a través del formulario disponible en el siguiente enlace.
            Estaremos encantados de atenderle a la mayor brevedad posible.
        </p>
        <div class="flex justify-center">
            <a href="{{ route('contact') }}" class="w-auto bg-primary hover:bg-[#66a499] text-white font-medium py-2 px-6 rounded-md transition duration-150 ease-in-out">
                Contáctenos
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#66a499] text-white py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="grid grid-cols-2 gap-8 items-center sm:grid-cols-4 lg:grid-cols-7">
                <a href="https://www.ugr.es/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-ugr.svg" alt="Universidad de Granada" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.arqus-alliance.eu/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-arqus-alliance.svg" alt="Arqus European University Alliance" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.universia.net/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-universia.svg" alt="Universia" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://euraxess.ec.europa.eu/jobs/hrs4r" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-excelencia.svg" alt="HR Excellence In Research" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.aepd.es/es/pacto-digital" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-pactodigital.svg" alt="Pacto Digital para la Protección de las Personas" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.universidades.gob.es/" target="_blank" rel="noopener noreferrer">
                    <img src="/assets/icons/logo-transparencia-universidades.svg" alt="Universidades 2024" class="w-32 h-32 mx-auto object-contain">
                </a>
                <a href="https://www.universidadespublicasdeandalucia.es/" target="_blank" rel="noopener noreferrer" class="col-span-2 sm:col-span-1 justify-self-center">
                    <img src="/assets/icons/logo-aupa.svg" alt="Universidades de Andalucía" class="w-32 h-32 mx-auto object-contain">
                </a>
            </div>
        </div>
    </footer>
    <footer class="bg-primary text-white py-6">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 flex flex-col sm:flex-row justify-between items-center">
            <div class="flex space-x-4">
                <a href="{{ route('privacy-policy') }}" class="text-sm hover:underline border-r-2 border-white pr-4">Política de privacidad</a>
                <a href="{{ route('terms-conditions') }}" class="text-sm hover:underline">Términos y condiciones</a>
            </div>
            <p class="text-sm text-center sm:text-left mb-4 sm:mb-0">© 2025 Clínica Universitaria de Visión y Optometría. Todos los derechos reservados.</p>
        </div>
    </footer>
</x-app-layout>