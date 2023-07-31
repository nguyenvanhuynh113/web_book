@extends('layouts.client')
@section('content')
    <div class="container col-md-10">
        <h3 class="mt-3 mb-2 text-uppercase">Thể loại / {{$typename->type_name}}</h3>
        <div class="album py-5 bg-light">
            <div class="container">
                @if($book->count()>0)
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2">
                        @foreach($book as $item)
                            <div class="col-md-2">
                                <div class="card shadow-sm">
                                    <img class="bd-placeholder-img card-img-top" style="max-height: 300px"
                                         src="{{$item->book_photo}}" role="img" aria-label="Placeholder: Thumbnail"
                                         preserveAspectRatio="xMidYMid slice" focusable="false"><title>
                                        Placeholder</title>
                                    <rect width="100%" max-height="300px" fill="#55595c"></rect>
                                    </img>
                                    <div class="card-body">
                                        <p class="card-text text-success" style="height: 40px">{{$item->name}}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-sm btn-outline-secondary"
                                                   href="{{route('xemsach',$item->id)}}">Detail
                                                </a>
                                            </div>
                                            <small class="text-muted"><i class="bi bi-eye"></i> {{$item->view}}</small>
                                            <small class="text-muted"><i class="bi bi-heart"></i> {{$item->like}}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h5 class="text-success"> Đang cập nhật ...</h5>
                @endif

            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $book->links('client/pagination/custom') }}
        </div>
        <hr>
        @include('layouts.client.noibat')
        <hr>
        @include('layouts.client.theloai')
        <hr>
        @include('layouts.client.footer')
    </div>
@endsection
