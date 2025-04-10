<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Cita') }}
            </h2>
            <a href="{{ route('appointments.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium transition-colors duration-150 ease-in-out flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Volver al listado</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <h1 class="text-xl font-bold sm:text-2xl mb-6">Crear nueva cita</h1>

                    <x-doctorappointment-form
                        :action="route('appointments.store')"
                        :patients="$patients"
                        :doctor="$doctor"
                        :schedules="$schedules"
                        :isEdit="false"
                    />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>