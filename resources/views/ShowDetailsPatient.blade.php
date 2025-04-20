<x-app-layout>
    <div class="py-8 sm:py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="px-6 py-6 sm:px-8 sm:py-8 text-gray-900">
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-xl font-bold sm:text-2xl">Detalles del Paciente</h1>
                        <x-back-link :url="route('patients.index')" />
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="bg-teal-50 border border-teal-200 rounded-md p-6 shadow-sm">
                            <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Información Personal
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Nombre completo:</p>
                                    <p class="text-gray-800" id="name">
                                        {{ ucfirst($patient->name ?? '') }} {{ ucfirst($patient->surnames ?? '') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Email:</p>
                                    <p class="text-gray-800" id="email">
                                        {{ $patient->email ?? 'No especificado' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Fecha de nacimiento:</p>
                                    <p class="text-gray-800" id="birthdate">
                                        {{ $patient->birthdate ?? 'No especificado' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Teléfono:</p>
                                    <p class="text-gray-800" id="phone">
                                        {{ $patient->phone ?? 'No especificado' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">DNI:</p>
                                    <p class="text-gray-800" id="dni">
                                        {{ $patient->dni ?? 'No especificado' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if (
                            !empty($patient->tutor_name) ||
                                !empty($patient->tutor_email) ||
                                !empty($patient->tutor_dni) ||
                                !empty($patient->tutor_phone))
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-6 shadow-sm">
                                <h3 class="text-lg font-semibold text-blue-700 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Información del Tutor Legal
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Nombre del tutor:</p>
                                        <p class="text-gray-800" id="tutor_name">
                                            {{ $patient->tutor_name ?? 'No especificado' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Correo del tutor:</p>
                                        <p class="text-gray-800" id="tutor_email">
                                            {{ $patient->tutor_email ?? 'No especificado' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">DNI del tutor:</p>
                                        <p class="text-gray-800" id="tutor_dni">
                                            {{ $patient->tutor_dni ?? 'No especificado' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Teléfono del tutor:</p>
                                        <p class="text-gray-800" id="tutor_phone">
                                            {{ $patient->tutor_phone ?? 'No especificado' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
