@extends('errors::minimal', [
    'title' => 'Página no encontrada - 404',
    'bgGradient' => 'from-indigo-50 to-blue-100',
])

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-indigo-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection

@section('content')
    <h1 class="text-6xl md:text-8xl font-bold text-indigo-900 mb-6">404</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Página no encontrada</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
        Lo sentimos, no pudimos encontrar la página que estás buscando.
    </p>
@endsection

@section('actions')
    <a href="{{ route('home') }}"
        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
        Volver al inicio
    </a>
    <a href="{{ url()->previous() }}"
        class="px-6 py-3 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-medium rounded-lg transition duration-300">
        Volver atrás
    </a>
@endsection
