@extends('errors::minimal', [
    'title' => 'Acceso no autorizado - 401',
    'bgGradient' => 'from-purple-50 to-indigo-100',
])

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-purple-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
    </svg>
@endsection

@section('content')
    <h1 class="text-6xl md:text-8xl font-bold text-purple-900 mb-6">401</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Acceso no autorizado</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
        Debes autenticarte para acceder a este recurso.
    </p>
@endsection

@section('actions')
    <a href="{{ route('login') }}"
        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
        Iniciar sesión
    </a>
    <a href="{{ route('home') }}"
        class="px-6 py-3 border border-purple-600 text-purple-600 hover:bg-purple-50 font-medium rounded-lg transition duration-300">
        Volver al inicio
    </a>
@endsection
