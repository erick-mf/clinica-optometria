<x-app-layout>
    <div class="py-6 sm:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-4 sm:p-8 text-gray-900">
                    <!-- Título -->
                    <div class="mb-6 flex flex-row justify-between items-start sm:items-center gap-4">
                        <h1 class="text-lg font-bold sm:text-xl text-gray-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Reservas del personal
                        </h1>
                        <x-back-link :url="route('admin.dashboard')" />
                    </div>

                    <!-- Mensaje cuando no hay reservas -->
                    @if ($reservations->isEmpty())
                        <div class="bg-gradient-to-br from-gray-50 to-teal-50 rounded-lg p-8 sm:p-12 text-center border border-gray-200 shadow-sm"
                            style="background: linear-gradient(to bottom right, #f9fafb, rgba(21, 117, 100, 0.1));">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-6 opacity-80"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #157564;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No hay reservas</h3>
                        </div>
                    @else
                        <!-- Vista móvil: tarjetas -->
                        <div class="sm:hidden space-y-4 mb-6">
                            @foreach ($reservations as $reservation)
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 hover:shadow-md transition-shadow duration-200 relative overflow-hidden">
                                    <div class="absolute top-0 right-0 bg-teal-700 text-white px-3 py-1 font-bold rounded-bl-lg"
                                        style="background-color: #157564;">
                                        {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('l') }}
                                    </div>
                                    <div class="mb-3">
                                        <span class="font-semibold text-lg text-gray-800 block">
                                            {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-sm text-gray-600">Prof: <span
                                                class="text-gray-800">{{ $reservation->doctor->name }}</span></span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-sm text-gray-600">Motivo: <span
                                                class="text-gray-800">{{ $reservation->details }}</span></span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-sm text-gray-600">Espacio: <span
                                                class="text-gray-800">{{ $reservation->office->abbreviation }}</span></span>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-600">Horario:</span>
                                        <span
                                            class="inline-block px-3 py-1.5 bg-teal-50 text-teal-700 text-xs font-medium rounded-full whitespace-nowrap"
                                            style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                            {{ \Carbon\Carbon::createFromFormat('H:i', $reservation->start_time)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::createFromFormat('H:i', $reservation->end_time)->format('H:i') }}
                                        </span>
                                    </div>
                                    <!-- Acciones -->
                                    <div class="mt-4">
                                        <x-action-delete-button
                                            action="{{ route('admin.reserved-times.destroy', $reservation->id) }}" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Vista desktop: tabla -->
                        <div
                            class="hidden sm:block overflow-hidden bg-white rounded-xl shadow-sm border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-teal-50"
                                    style="background: linear-gradient(to right, #f9fafb, rgba(21, 117, 100, 0.1));">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Día
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Profesional
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-wrap">
                                            Motivo
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Espacio
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Horario
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($reservations as $reservation)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center text-gray-700">
                                                    {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="text-gray-700">
                                                    {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('l') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-gray-700">{{ $reservation->doctor->name }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-gray-700">{{ $reservation->details }}</span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span
                                                    class="text-gray-700">{{ $reservation->office->abbreviation }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-block px-3 py-1.5 bg-teal-50 text-teal-700 text-xs font-medium rounded-full whitespace-nowrap"
                                                    style="background-color: rgba(21, 117, 100, 0.1); color: #157564;">
                                                    {{ \Carbon\Carbon::createFromFormat('H:i', $reservation->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::createFromFormat('H:i', $reservation->end_time)->format('H:i') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-action-delete-button
                                                    action="{{ route('admin.reserved-times.destroy', $reservation->id) }}" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6" id="paginate">
                            <x-custom-pagination :paginator="$reservations" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-delete-modal title="Confirmar eliminación"
        content="¿Estás seguro que deseas eliminar esta reserva? Esta acción no se puede deshacer." />
</x-app-layout>
