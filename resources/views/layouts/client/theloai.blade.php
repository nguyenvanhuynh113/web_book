<h4 class="mt-2 mb-3 mt-5"> Tất cả thể loại</h4>
<div class="button-container">
    @foreach($type as $val)
        <a href="{{ route('bookbytype', $val->id) }}"
           class="btn btn-outline-success btn-block m-sm-1">{{ $val->type_name }}</a>
    @endforeach
</div>
