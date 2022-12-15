@if ($paginator['paginator']->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator['paginator']->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link"></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev"></a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator['paginator']->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next"></a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link"></span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted">
                    {!! lang('pagination.showing') !!}
                    <span class="font-medium">{{ $paginator['paginator']->firstItem() }}</span>
                    {!! lang('pagination.to') !!}
                    <span class="font-medium">{{ $paginator['paginator']->lastItem() }}</span>
                    {!! lang('pagination.of') !!}
                    <span class="font-medium">{{ $paginator['paginator']->total() }}</span>
                    {!! lang('pagination.results') !!}
                </p>
            </div>

            <div>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator['paginator']->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="pagination.previous">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $uri . $paginator['paginator']->previousPageUrl() }}" rel="prev" aria-label="pagination.previous">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($paginator['elements'] as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator['paginator']->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $uri . $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator['paginator']->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $uri . $paginator['paginator']->nextPageUrl() }}" rel="next" aria-label="pagination.next">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="pagination.next">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
