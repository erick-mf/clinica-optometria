@extends('errors::minimal', [
    'title' => 'Error del servidor - 500',
    'bgGradient' => 'from-red-50 to-pink-100',
])

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-red-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
    </svg>
@endsection

@section('content')
    <h1 class="text-6xl md:text-8xl font-bold text-red-900 mb-6">500</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Error del servidor</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
        Algo salió mal en nuestro servidor. Nuestro equipo ha sido notificado y estamos trabajando para solucionarlo.
    </p>
@endsection

@section('actions')
    <button onclick="window.location.reload()"
        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
        Reintentar
    </button>
    <a href="{{ route('home') }}"
        class="px-6 py-3 border border-red-600 text-red-600 hover:bg-red-50 font-medium rounded-lg transition duration-300">
        Ir al inicio
    </a>
    <a href="{{ config('app.support_email') }}"
        class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition duration-300">
        Contactar soporte
    </a>
@endsection
