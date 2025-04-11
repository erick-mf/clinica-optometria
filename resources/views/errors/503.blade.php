@extends('errors::minimal', [
    'title' => 'Servicio no disponible - 503',
    'bgGradient' => 'from-blue-50 to-cyan-100',
])

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
    </svg>
@endsection

@section('content')
    <h1 class="text-6xl md:text-8xl font-bold text-blue-900 mb-6">503</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Servicio no disponible</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
        Estamos realizando tareas de mantenimiento. Por favor, vuelve a intentarlo en unos minutos.
    </p>

    <div class="mb-8">
        <div class="inline-block bg-white rounded-lg shadow-md px-6 py-4">
            <span class="text-2xl font-mono font-bold text-blue-600">Volvemos en <span id="countdown">30:00</span></span>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Contador regresivo de 5 minutos
        let timeLeft = 1800;
        const countdownElement = document.getElementById('countdown');
        const countdownInterval = setInterval(() => {
            timeLeft--;

            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            countdownElement.textContent =
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = "¡Ya estamos de vuelta!";
                setTimeout(() => window.location.reload(), 2000);
            }
        }, 1000);
    </script>
@endsection
