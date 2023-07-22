<ul class="pagination">
    <!-- Hiển thị liên kết phân trang theo ý muốn -->
    <li class="page-item"><a class="page-link" href="{{$paginator->previousPageUrl()}}">Previous</a></li>
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled page-item"><span class="page-link">{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active page-item"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    <li class="page-item"><a class="page-link" href=" {{$paginator->nextPageUrl()}}">Next</a></li>
</ul>
