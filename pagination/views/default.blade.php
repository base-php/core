@if ($paginator['paginator']->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator['paginator']->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="pagination.previous">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev" aria-label="pagination.previous">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($paginator['elements'] as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator['paginator']->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $uri . $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator['paginator']->hasMorePages())
                <li>
                    <a href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next" aria-label="pagination.next">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="pagination.next">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
