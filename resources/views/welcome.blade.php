<x-app-layout>
    <!-- Barra de redes sociales -->
    <x-rrss />

    <!-- Hero Section-->
    <section class="relative w-full sm:h-[83svh] h-[50svh] min-h-[518px] max-h-[900px] overflow-hidden">
        <div class="absolute inset-0">
            <picture>
                <source media="(min-width: 768px)" srcset="/images/img5.webp" type="image/webp">
                <source srcset="/images/img5-mobile.webp" type="image/webp">
                <img src="/images/img5-mobile.jpg" alt="Profesional realizando examen de la vista"
                    class="w-full h-full object-cover object-center md:object-[center_30%]" loading="eager"
                    decoding="async" fetchpriority="high">
            </picture>
        </div>

        <div
            class="absolute inset-0 bg-gradient-to-b from-transparent via-black/40 to-black/90 flex flex-col justify-center items-center px-6 sm:px-8 text-center">
            <div class="max-w-4xl mx-auto space-y-6">
                <h1
                    class="text-4xl sm:text-5xl md:text-6xl font-bold text-white leading-tight drop-shadow-xl animate-fade-in">
                    Tu visión, nuestra prioridad.
                </h1>
                <p
                    class="text-xl sm:text-2xl text-white/90 leading-relaxed max-w-2xl mx-auto drop-shadow-md animate-fade-in [animation-delay:100ms]">
                    Expertos en el cuidado integral de tus ojos. Pide tu cita hoy mismo.
                </p>
                <div class="animate-fade-in [animation-delay:200ms]">
                    <a href="{{ route('book-appointment') }}"
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-dark text-white font-medium rounded-full px-8 py-4 sm:px-10 sm:py-4 text-lg transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Pedir Cita
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de ubicación - Rediseñada para mejor flujo -->
    <section class="bg-white py-14 sm:py-20 lg:py-22">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4">¿Dónde encontrarnos?</h2>
                <div class="w-20 h-1 bg-primary mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12">
                <div
                    class="relative rounded-xl overflow-hidden shadow-xl h-[400px] lg:h-[500px] transform transition-all duration-300 hover:shadow-2xl">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3178.805430064723!2d-3.6053723886933993!3d37.18109467202474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71fcea8c8d04d7%3A0xbcd461fa8bdad6b6!2sHospital%20San%20Rafael!5e0!3m2!1ses!2ses!4v1712148575847!5m2!1ses!2ses"
                        class="absolute inset-0 w-full h-full border-none" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Ubicación en mapa"></iframe>
                </div>

                <!-- Información de contacto mejorada -->
                <x-clinic-info />
            </div>
        </div>
    </section>

    <!-- Sección de contacto  -->
    <section class="bg-gradient-to-r bg-gray-100 py-14 sm:py-20 lg:py-22">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl text-center">
            <div
                class="bg-white rounded-2xl p-8 sm:p-10 shadow-2xl transform transition-all duration-300 hover:scale-[1.01]">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">¿Necesitas contactarnos?</h2>
                <p class="text-lg sm:text-xl text-gray-700 mb-8 leading-relaxed">
                    Estamos aquí para resolver tus dudas y atender tus consultas. No dudes en ponerte en contacto con
                    nuestro equipo de especialistas.
                </p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center bg-primary hover:bg-primary-darker text-white font-medium rounded-full px-8 py-4 text-lg transition-all duration-300 hover:shadow-lg hover:scale-105 active:scale-95">
                    Contáctenos
                    <svg class="ml-3 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <x-footer />
</x-app-layout>
