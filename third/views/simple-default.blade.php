@if ($paginator['paginator']->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator['paginator']->onFirstPage())
                <li class="disabled" aria-disabled="true"><span>{!! lang('pagination.previous') !!}</span></li>
            @else
                <li><a href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev">{!! lang('pagination.previous') !!}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator['paginator']->hasMorePages())
                <li><a href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next">{!! lang('pagination.next') !!}</a></li>
            @else
                <li class="disabled" aria-disabled="true"><span>{!! lang('pagination.next') !!}</span></li>
            @endif
        </ul>
    </nav>
@endif
