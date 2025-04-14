<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Mi Panel</h1>

            <!-- Tarjetas de Acceso Rápido -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- Mis Citas -->
                <a href="{{ route('appointments.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Mis Citas</h3>
                            <p class="text-sm text-gray-600">Revisa tus citas programadas</p>
                        </div>
                    </div>
                </a>

                <!-- Mis Pacientes -->
                <a href="{{ route('patients.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Mis Pacientes</h3>
                            <p class="text-sm text-gray-600">Revisa tus pacientes y su información</p>
                        </div>
                    </div>
                </a>

                <!-- Mis Horarios -->
                <a href="{{ route('admin.schedules.index') }}"
                    class="block p-4 sm:p-6 bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-4">
                        <div class="rounded-full p-3 flex-shrink-0" style="background-color: rgba(21, 117, 100, 0.1);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Mis Horarios</h3>
                            <p class="text-sm text-gray-600">Consulta tus horarios disponibles</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Sección de Últimas Citas -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="bg-gradient-to-r from-gray-50 to-teal-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between"
                    style="background: linear-gradient(to right, #f9fafb, rgba(21, 117, 100, 0.1));">
                    <div class="flex items-center gap-2">
                        <h3 class="text-lg font-semibold text-gray-800">Próximas Citas</h3>
                    </div>
                </div>

                <!-- Aquí puedes agregar la lógica para mostrar las citas -->
                <div class="bg-gradient-to-br from-gray-50 to-teal-50 rounded-lg p-8 sm:p-12 text-center border border-gray-200 shadow-sm m-6"
                    style="background: linear-gradient(to bottom right, #f9fafb, rgba(21, 117, 100, 0.1));">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-6 opacity-80"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay citas programadas</h3>
                    <p class="text-gray-600">Puedes programar citas para tus pacientes.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
