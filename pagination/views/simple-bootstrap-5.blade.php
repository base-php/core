@if ($paginator['paginator']->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator['paginator']->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{!! lang('Previous') !!}</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev">
                        {!! lang('Previous') !!}
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator['paginator']->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next">{!! lang('Next') !!}</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{!! lang('Next') !!}</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
