@if ($paginator->hasPages() && $paginator->lastPage() > 1)
    <div class="mt-6 flex justify-center w-full">
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center w-full">
            <div class="flex items-center space-x-1">
                {{-- Botón Anterior (versión móvil reducida) --}}
                <div class="flex-shrink-0">
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2  sm:text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            <span class="hidden sm:inline">{!! __('Anterior') !!}</span>
                            <span class="sm:hidden">&laquo;</span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                            class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2  sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                            <span class="hidden sm:inline">{!! __('Anterior') !!}</span>
                            <span class="sm:hidden">&laquo;</span>
                        </a>
                    @endif
                </div>

                {{-- Números de página con límite (versión móvil más compacta) --}}
                <div class="flex items-center space-x-1">
                    @php
                        // En móvil reducimos el window a 1 página a cada lado
                        $window = isset($isMobile) && $isMobile ? 1 : 2;
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();

                        // Definir el rango de páginas a mostrar
                        $startPage = max(1, $currentPage - $window);
                        $endPage = min($lastPage, $currentPage + $window);

                        // Ajustar para mostrar siempre el número correcto de páginas
                        if ($endPage - $startPage < 2 * $window) {
                            if ($startPage == 1) {
                                $endPage = min($lastPage, 1 + 2 * $window);
                            } elseif ($endPage == $lastPage) {
                                $startPage = max(1, $lastPage - 2 * $window);
                            }
                        }
                    @endphp

                    {{-- Primera página --}}
                    @if ($startPage > 1)
                        <a href="{{ $paginator->url(1) }}"
                            class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2 sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                            1
                        </a>

                        {{-- Elipsis si hay un salto --}}
                        @if ($startPage > 2)
                            <span
                                class="relative inline-flex items-center px-1 py-1 sm:py-2  sm:text-sm font-medium text-gray-700">
                                ..
                            </span>
                        @endif
                    @endif

                    {{-- Rango de páginas --}}
                    @foreach (range($startPage, $endPage) as $page)
                        @if ($page == $currentPage)
                            <span
                                class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2  sm:text-sm font-medium text-white bg-primary hover:bg-teal-800 cursor-default rounded-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $paginator->url($page) }}"
                                class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2  sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Elipsis y última página --}}
                    @if ($endPage < $lastPage)
                        {{-- Elipsis si hay un salto --}}
                        @if ($endPage < $lastPage - 1)
                            <span
                                class="relative inline-flex items-center px-1 py-1 sm:py-2 sm:text-sm font-medium text-gray-700">
                                ..
                            </span>
                        @endif

                        <a href="{{ $paginator->url($lastPage) }}"
                            class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2  sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                            {{ $lastPage }}
                        </a>
                    @endif
                </div>

                {{-- Botón Siguiente (versión móvil reducida) --}}
                <div class="flex-shrink-0">
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                            class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                            <span class="hidden sm:inline">{!! __('Siguiente') !!}</span>
                            <span class="sm:hidden">&raquo;</span>
                        </a>
                    @else
                        <span
                            class="relative inline-flex items-center px-2 py-1 sm:px-3 sm:py-2 text-xs sm:text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            <span class="hidden sm:inline">{!! __('Siguiente') !!}</span>
                            <span class="sm:hidden">&raquo;</span>
                        </span>
                    @endif
                </div>
            </div>
        </nav>
    </div>
@endif
