<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-xl font-bold sm:text-2xl">Crear nueva Cita</h1>

                        <x-back-link :url="route('patients.index')" />
                    </div>

                    <x-doctorappointment-form :action="route('appointments.store')" :patient="$patient_id" :doctor="$doctor" :schedules="$schedules"
                        :availableSlots="$availableSlots" :isEdit="false" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
