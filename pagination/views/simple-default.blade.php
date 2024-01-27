@if ($paginator['paginator']->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator['paginator']->onFirstPage())
                <li class="disabled" aria-disabled="true"><span>{!! lang('Previous') !!}</span></li>
            @else
                <li><a href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev">{!! lang('Previous') !!}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator['paginator']->hasMorePages())
                <li><a href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next">{!! lang('Next') !!}</a></li>
            @else
                <li class="disabled" aria-disabled="true"><span>{!! lang('Next') !!}</span></li>
            @endif
        </ul>
    </nav>
@endif
