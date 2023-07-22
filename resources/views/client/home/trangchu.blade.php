@extends('layouts.client')
@section('content')
    <div class="container">
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
                                    <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('xemsach',$item->id)}}">Detail</a>
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
        <h3 class="mt-5 mb-3 text-uppercase">Sach-Truyen moi cap nhat <i class="bi bi-lightning-charge-fill"
                                                                         style="color: rgb(255, 165, 0, 1)"></i>
            <span><a href="" class="btn btn-outline-success text-lowercase" style="float: right">view all <i
                        class="bi bi-arrow-right"></i></a> </span></h3>
        <div class="row">
            <div class="owl-carousel owl-theme">
                @foreach($new as $item)
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
                                    <a type="button" class="btn btn-sm btn-outline-secondary" href="{{route('xemsach',$item->id)}}">Detail</a>
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
        <h3 class="mt-5 mb-3 text-uppercase">Sach-Truyen xem nhieu <i class="bi bi-lightning-charge-fill"
                                                                      style="color: rgb(255, 165, 0, 1)">
            </i><span><a href="" class="btn btn-outline-success text-lowercase" style="float: right">view all <i
                        class="bi bi-arrow-right"></i></a></span></h3>
        <div class="row">
            <div class="owl-carousel owl-theme">
                @foreach($view as $item)
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
                                    <a  href="{{route('xemsach',$item->id)}}" type="button" class="btn btn-sm btn-outline-secondary">Detail</a>
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
        <h3 class="mt-5 mb-3">Blogs</h3>
        <div class="row mb-2">
            <div class="col-md-6">
                <div
                    class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">World</strong>
                        <h3 class="mb-0">Featured post</h3>
                        <div class="mb-1 text-muted">Nov 12</div>
                        <p class="card-text mb-auto">This is a wider card with supporting text below as a natural
                            lead-in to additional content.</p>
                        <a href="#" class="stretched-link">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img class="bd-placeholder-img" width="200" height="250" src="http://www.w3.org/2000/svg"
                             role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                             focusable="false"><title>Placeholder</title>
                        </img>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div
                    class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-success">Design</strong>
                        <h3 class="mb-0">Post title</h3>
                        <div class="mb-1 text-muted">Nov 11</div>
                        <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to
                            additional content.</p>
                        <a href="#" class="stretched-link">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <img class="bd-placeholder-img" width="200" height="250" src="http://www.w3.org/2000/svg"
                             role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                             focusable="false"><title>Placeholder</title>
                        </img>
                    </div>
                </div>
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
