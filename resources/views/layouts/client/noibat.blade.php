
<h3 class="mt-5 mb-3 text-uppercase">Nổi bật <i class="bi bi-fire"
                                                style="color: rgb(255, 165, 0, 1)"></i><span><a
            href="" class="btn btn-outline-success text-lowercase" style="float: right">view all <i
                class="bi bi-arrow-right"></i></a> </span></h3>
<div class="row">
    <div class="owl-carousel owl-theme">
        @foreach($carousel as $item)
            @php
                $view=\Illuminate\Support\Facades\DB::table('likes')->where('id_book',$item->id)->get();
                $countLike=$view->count();
            @endphp
            <div class="card shadow-sm">
                <img class="bd-placeholder-img card-img-top" style="max-height: 300px"
                     src="{{$item->book_photo}}" role="img" aria-label="Placeholder: Thumbnail"
                     preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title>
                <rect width="100%" max-height="300px" fill="#55595c"></rect>
                </img>
                <div class="card-body">
                    <p class="card-text text-success" style="height: 40px">{{\Illuminate\Support\Str::limit($item->name,30)}}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a type="button" class="btn btn-sm btn-outline-success"
                               href="{{route('xemsach',$item->id)}}">Detail</a>
                        </div>
                        <small class="text-muted"><i class="bi bi-eye"></i> {{$item->view}}</small>
                        <small class="text-muted"><i class="bi bi-heart"></i> {{$countLike}}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
