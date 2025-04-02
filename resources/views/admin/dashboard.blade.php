<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel de Administración</h1>

                    <p class="text-gray-600 mb-8">Bienvenido al panel de administración. Aquí puedes gestionar los
                        doctores, pacientes, citas y horarios.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white">
                        <a href="{{ route('admin.doctors.index') }}"
                            class="block p-6 bg-primary hover:bg-[#66a499] rounded-lg transition duration-300">
                            <h2 class="text-xl font-semibold mb-2">Gestionar Doctores</h2>
                            <p>Administra los doctores y sus perfiles</p>
                        </a>
                        <a href="{{ route('admin.patients.index') }}"
                            class="block p-6 bg-primary hover:bg-[#66a499] rounded-lg transition duration-300">
                            <h2 class="text-xl font-semibold mb-2">Gestionar Pacientes</h2>
                            <p>Administra los pacientes y su información</p>
                        </a>
                        <a href="{{ route('admin.doctors.index') }}"
                            class="block p-6 bg-primary hover:bg-[#66a499] rounded-lg transition duration-300">
                            <h2 class="text-xl font-semibold mb-2">Gestionar Citas</h2>
                            <p>Revisa y gestiona las citas programadas</p>
                        </a>
                        <a href="{{ route('admin.schedules.index') }}"
                            class="block p-6 bg-primary hover:bg-[#66a499] rounded-lg transition duration-300">
                            <h2 class="text-xl font-semibold mb-2">Gestionar Horarios</h2>
                            <p>Administra los horarios disponibles para los doctores</p>
                        </a>
                    </div>

                    {{-- Últimas citas --}}
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg">Últimas Citas</h3>
                        <ul class="list-group">
                            @foreach ($data['latestAppointments'] as $appointment)
                                <li class="list-group-item">
                                    <strong>Paciente:</strong> {{ $appointment['patient'] }} |
                                    <strong>Doctor:</strong> {{ $appointment['doctor'] }} |
                                    <strong>Fecha:</strong> {{ $appointment['date'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
