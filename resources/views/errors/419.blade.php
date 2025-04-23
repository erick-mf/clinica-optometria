@extends('errors::minimal', [
    'title' => 'Página expirada - 419',
    'bgGradient' => 'from-amber-50 to-yellow-100',
])

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-amber-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection

@section('content')
    <h1 class="text-6xl md:text-8xl font-bold text-amber-900 mb-6">419</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Página expirada</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
        La sesión ha expirado. Por favor, actualiza la página e intenta nuevamente.
    </p>
@endsection

@section('actions')
    <a href="{{ route('home') }}"
        class="px-6 py-3 border border-amber-600 text-amber-600 hover:bg-amber-50 font-medium rounded-lg transition duration-300">
        Ir al inicio
    </a>
@endsection
