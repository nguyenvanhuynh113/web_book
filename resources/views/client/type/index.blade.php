@extends('layouts.client')
@section('content')
    <div class="container">
        <h3 class="mt-3 mb-2 text-uppercase">Truyen-Sach / {{$typename->type_name}}</h3>
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
        <h3 class="mt-5 mb-3 text-uppercase">Sach-Truyen noi bat <i class="bi bi-fire"
                                                                    style="color: rgb(255, 165, 0, 1)"></i><span><a
                    href="" class="btn btn-outline-success text-lowercase" style="float: right">view all <i
                        class="bi bi-arrow-right"></i></a> </span></h3>
        <div class="row">
            <div class="owl-carousel owl-theme">
                @foreach($carousel as $item)
                    <div class="card shadow-sm">
                        <img class="bd-placeholder-img card-img-top" style="max-height: 300px"
                             src="{{$item->book_photo}}" role="img" aria-label="Placeholder: Thumbnail"
                             preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title>
                        <rect width="100%" max-height="300px" fill="#55595c"></rect>
                        </img>
                        <div class="card-body">
                            <p class="card-text text-success" style="height: 40px">{{$item->name}}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a type="button" class="btn btn-sm btn-outline-secondary"
                                       href="{{route('xemsach',$item->id)}}">Detail</a>
                                </div>
                                <small class="text-muted"><i class="bi bi-eye"></i> {{$item->view}}</small>
                                <small class="text-muted"><i class="bi bi-heart"></i> {{$item->like}}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <h4 class="mt-2 mb-3">The Loai Truyen-Sach</h4>
        <div class="d-inline-flex">
            @foreach($type as $val)
                <a href="{{route('bookbytype',$val->id)}}" class="btn btn-outline-secondary m-1">{{$val->type_name}}</a>
            @endforeach
        </div>
        <hr>
        @include('layouts.client.footer')
    </div>
@endsection
