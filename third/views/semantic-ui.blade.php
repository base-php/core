@if ($paginator['paginator']->hasPages())
    <div class="ui pagination menu" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator['paginator']->onFirstPage())
            <a class="icon item disabled" aria-disabled="true" aria-label="pagination.previous"> <i class="left chevron icon"></i> </a>
        @else
            <a class="icon item" href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev" aria-label="pagination.previous"> <i class="left chevron icon"></i> </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator['elements'] as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="icon item disabled" aria-disabled="true">{{ $element }}</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator['paginator']->currentPage())
                        <a class="item active" href="{{ $uri . $url }}" aria-current="page">{{ $page }}</a>
                    @else
                        <a class="item" href="{{ $uri . $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator['paginator']->hasMorePages())
            <a class="icon item" href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next" aria-label="pagination.next"> <i class="right chevron icon"></i> </a>
        @else
            <a class="icon item disabled" aria-disabled="true" aria-label="pagination.next"> <i class="right chevron icon"></i> </a>
        @endif
    </div>
@endif
