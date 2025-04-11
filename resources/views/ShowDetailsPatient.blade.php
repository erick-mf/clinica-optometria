<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 sm:p-8 text-gray-900">
                    <!-- Encabezado -->
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800">Detalles del Paciente</h1>
                        <a href="{{ route('patients.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver al listado
                        </a>
                    </div>

                    <!-- Información del Paciente -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="bg-teal-100 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Información del Paciente</h3>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Nombre completo:</p>
                                <p class="text-lg font-medium text-gray-800">{{ ucfirst($patient->name) }} {{ ucfirst($patient->surnames) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email:</p>
                                <p class="text-lg font-medium text-gray-800">{{ $patient->email ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Fecha de nacimiento:</p>
                                <p class="text-lg font-medium text-gray-800">{{ $patient->birthdate ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Teléfono:</p>
                                <p class="text-lg font-medium text-gray-800">{{ $patient->phone ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">DNI:</p>
                                <p class="text-lg font-medium text-gray-800">{{ $patient->dni ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>