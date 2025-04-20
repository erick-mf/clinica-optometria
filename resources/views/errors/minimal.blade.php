<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Error' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br {{ $bgGradient ?? 'from-gray-50 to-blue-100' }} min-h-screen flex items-center">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Icono-->
            @hasSection('icon')
                @yield('icon')
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif

            <!-- Contenido principal -->
            @yield('content')

            <!-- Acciones adicionales -->
            @yield('actions')
        </div>
    </div>
    @yield('scripts')
</body>

</html>
