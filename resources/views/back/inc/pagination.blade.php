@if ($paginator->hasPages())

    <ul class="uk-pagination" uk-margin>

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><a href="{{ $paginator->previousPageUrl() }}"><span class="uk-margin-small-right" uk-pagination-previous></span> قبلی</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="uk-disabled"><span>...</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="uk-active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="uk-margin-auto-left">
                <a href="{{ $paginator->nextPageUrl() }}">بعدی <span class="uk-margin-small-left" uk-pagination-next></span></a>
            </li>
        @endif

    </ul>
@endif
