@extends('errors::minimal', [
    'title' => 'Demasiadas solicitudes - 429',
    'bgGradient' => 'from-orange-50 to-red-100',
])

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-orange-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
    </svg>
@endsection

@section('content')
    <h1 class="text-6xl md:text-8xl font-bold text-orange-900 mb-6">429</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Demasiadas solicitudes</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
        Has realizado demasiadas solicitudes al servidor. Por favor, espera un momento antes de intentar nuevamente.
    </p>
@endsection

@section('actions')
    <button onclick="window.location.reload()"
        class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
        Reintentar
    </button>
    <a href="{{ route('home') }}"
        class="px-6 py-3 border border-orange-600 text-orange-600 hover:bg-orange-50 font-medium rounded-lg transition duration-300">
        Ir al inicio
    </a>
@endsection
