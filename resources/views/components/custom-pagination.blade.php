<div class="mt-6 flex justify-center w-full">
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center w-full max-w-lg">
        <div class="flex justify-between w-full">
            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                    {!! __('Anterior') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                    {!! __('Anterior') !!}
                </a>
            @endif

            {{-- Números de página --}}
            <div class="flex items-center space-x-2">
                @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-teal-800 cursor-default rounded-md">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue transition ease-in-out duration-150">
                    {!! __('Siguiente') !!}
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                    {!! __('Siguiente') !!}
                </span>
            @endif
        </div>
    </nav>
</div>
