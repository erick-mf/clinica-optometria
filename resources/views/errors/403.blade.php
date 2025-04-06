@extends('errors::minimal', [
    'title' => 'Acceso prohibido - 403',
    'bgGradient' => 'from-red-50 to-pink-100',
])

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-red-600" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zM12 8v4m0 4h.01" />
    </svg>
@endsection

@section('content')
    <h1 class="text-6xl md:text-8xl font-bold text-red-900 mb-6">403</h1>
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">Acceso prohibido</h2>
    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto">
        No tienes permiso para acceder a este recurso.
    </p>
@endsection

@section('actions')
    <a href="{{ route('home') }}"
        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
        Volver al inicio
    </a>
    @auth
        <a href="{{ url()->previous() }}"
            class="px-6 py-3 border border-red-600 text-red-600 hover:bg-red-50 font-medium rounded-lg transition duration-300">
            Volver atrás
        </a>
    @endauth
@endsection
