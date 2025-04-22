    <div class="bg-[#66a499] py-10 sm:py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4 sm:gap-6 items-center">
                <a href="https://www.ugr.es/" target="_blank" rel="noopener noreferrer"
                    class="flex justify-center p-2 sm:p-3 hover:opacity-90 transition-opacity duration-300">
                    <img src="/assets/icons/logo-ugr.svg" alt="Universidad de Granada"
                        class="h-16 sm:h-14 md:h-16 lg:h-18 object-contain object-center">
                </a>
                <a href="https://www.arqus-alliance.eu/" target="_blank" rel="noopener noreferrer"
                    class="flex justify-center p-2 sm:p-3 hover:opacity-90 transition-opacity duration-300">
                    <img src="/assets/icons/logo-arqus-alliance.svg" alt="Arqus European University Alliance"
                        class="h-10 sm:h-14 md:h-16 lg:h-18 object-contain object-center">
                </a>
                <a href="https://euraxess.ec.europa.eu/jobs/hrs4r" target="_blank" rel="noopener noreferrer"
                    class="flex justify-center p-2 sm:p-3 hover:opacity-90 transition-opacity duration-300">
                    <img src="/assets/icons/logo-excelencia.svg" alt="HR Excellence In Research"
                        class="h-12 sm:h-14 md:h-16 lg:h-18 object-contain object-center">
                </a>

                <a href="https://www.universidadespublicasdeandalucia.es/" target="_blank" rel="noopener noreferrer"
                    class="flex justify-center p-2 sm:p-3 hover:opacity-90 transition-opacity duration-300">
                    <img src="/assets/icons/logo-aupa.svg" alt="Universidades de Andalucía"
                        class="h-10 sm:h-14 md:h-16 lg:h-18 object-contain object-center">
                </a>
                <a href="https://www.aepd.es/es/pacto-digital" target="_blank" rel="noopener noreferrer"
                    class="flex justify-center p-2 sm:p-3 hover:opacity-90 transition-opacity duration-300">
                    <img src="/assets/icons/logo-pactodigital.svg"
                        alt="Pacto Digital para la Protección de las Personas"
                        class="h-12 sm:h-14 md:h-16 lg:h-18 object-contain object-center">
                </a>
                <a href="https://www.universidades.gob.es/" target="_blank" rel="noopener noreferrer"
                    class="flex justify-center p-2 sm:p-3 hover:opacity-90 transition-opacity duration-300">
                    <img src="/assets/icons/logo-transparencia-universidades.svg" alt="Universidades 2024"
                        class="h-12 sm:h-14 md:h-16 lg:h-18 object-contain object-center">
                </a>
                <a href="https://www.universia.net/" target="_blank" rel="noopener noreferrer"
                    class="flex justify-center p-2 sm:p-3 hover:opacity-90 transition-opacity duration-300">
                    <img src="/assets/icons/logo-universia.svg" alt="Universia"
                        class="h-8 sm:h-14 md:h-16 lg:h-18 object-contain object-center">
                </a>
            </div>
        </div>
    </div>

    <!-- Footer legal - Más compacto y funcional -->
    <footer class="bg-primary text-white py-6">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                    <a href="{{ route('privacy-policy') }}"
                        class="text-sm hover:text-white/80 transition-colors duration-300 sm:border-r sm:border-white sm:pr-4">
                        Política de privacidad
                    </a>
                    <a href="{{ route('terms-conditions') }}"
                        class="text-sm hover:text-white/80 transition-colors duration-300">
                        Términos y condiciones
                    </a>
                </div>
                <p class="text-sm">
                    © 2025 Clínica Universitaria de Visión y Optometría. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>
