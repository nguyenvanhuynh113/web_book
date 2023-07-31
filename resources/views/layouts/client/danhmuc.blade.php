<h4 class="mt-2 mb-3 mt-5">Tất cả danh mục</h4>
<div class="button-container">
    @foreach($cat as $val)
        <a href="{{ route('bookbycat', $val->id) }}"
           class="btn btn-outline-success btn-block m-sm-1">{{ $val->category_name }}</a>
    @endforeach
</div>
