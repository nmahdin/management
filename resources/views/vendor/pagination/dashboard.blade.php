@if ($paginator->hasPages())
    <div class="card-inner">
        <ul class="pagination justify-content-center justify-content-md-start">
            {{-- لینک قبلی --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><a class="page-link">قبلی</a></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">قبلی</a></li>
            @endif

            {{-- شماره صفحات --}}
            @foreach ($elements as $element)
                {{-- سه نقطه --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                @endif

                {{-- لینک‌های عددی --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active bg-primary text-white"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- لینک بعدی --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">بعدی</a></li>
            @else
                <li class="page-item disabled"><a class="page-link">بعدی</a></li>
            @endif
        </ul>
    </div>
@endif
