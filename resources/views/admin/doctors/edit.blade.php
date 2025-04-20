<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Profesional') }}
            </h2>
            <a href="{{ route('admin.doctors.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-150 ease-in-out flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Volver al listado</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-xl font-bold sm:text-2xl mb-6">Editar profesional</h1>
                        @if ($doctor && is_null($doctor->password))
                            <form method="POST" action="{{ route('admin.doctors.resendSetupLink', $doctor) }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors duration-150 ease-in-out flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Reenviar enlace de configuración
                                </button>
                            </form>
                        @endif
                    </div>

                    <x-doctor-form :doctor="$doctor" :action="route('admin.doctors.update', $doctor)" :isEdit="true" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
