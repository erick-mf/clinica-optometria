<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel del Doctorado</h1>

                    <p class="text-gray-600 mb-8">Bienvenido al panel del doctorado. Aquí puedes ver tus
                        pacientes, citas y horarios.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white">
                        <a href="{{ route('appointments.index') }}"
                            class="block p-6 bg-primary hover:bg-[#66a499] rounded-lg transition duration-300">
                            <h2 class="text-xl font-semibold mb-2">Mis Citas</h2>
                            <p>Revisa tus citas programadas</p>
                        </a>
                        <a href="{{ route('patients.index') }}"
                            class="block p-6 bg-primary hover:bg-[#66a499] rounded-lg transition duration-300">
                            <h2 class="text-xl font-semibold mb-2">Mis Pacientes</h2>
                            <p>Revisa tus pacientes y su información</p>
                        </a>
                        <a href="{{ route('admin.schedules.index') }}"
                            class="block p-6 bg-primary hover:bg-[#66a499] rounded-lg transition duration-300">
                            <h2 class="text-xl font-semibold mb-2">Mis Horarios</h2>
                            <p>Consulta tus horarios disponibles</p>
                        </a>
                    </div>

                    {{-- Últimas citas --}}
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg">Tus últimas Citas</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

