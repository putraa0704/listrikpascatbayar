@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-1 mt-6">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm bg-gray-200 text-gray-500 rounded-md cursor-not-allowed select-none">
                &laquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 text-sm bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150 ease-in-out">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-sm text-gray-500 select-none">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 text-sm font-semibold bg-green-700 text-white rounded-md shadow-sm select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-2 text-sm bg-green-100 text-green-800 hover:bg-green-200 rounded-md transition duration-150 ease-in-out">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-2 text-sm bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150 ease-in-out">
                &raquo;
            </a>
        @else
            <span class="px-3 py-2 text-sm bg-gray-200 text-gray-500 rounded-md cursor-not-allowed select-none">
                &raquo;
            </span>
        @endif
    </nav>
@endif
