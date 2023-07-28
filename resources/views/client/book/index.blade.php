@extends('layouts.client')
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h3 class="mt-3 mb-2"><i class="bi bi-arrow-bar-right"></i>{{$book->name}}</h3>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div
                            class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                            <div class="col-auto d-none d-lg-block">
                                <img class="bd-placeholder-img card-img-top" style="height: 400px"
                                     src="{{$book->book_photo}}" role="img" aria-label="Placeholder: Thumbnail"
                                     preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title>
                                <rect width="100%" max-height="300px" fill="#55595c"></rect>
                                </img>

                            </div>
                            <div class="col p-4 d-flex flex-column position-static">
                                <strong class="d-inline-block mb-2 text-primary"></strong>
                                <h3 class="mb-0 text-uppercase text-bold">{{$book->name}}</h3>
                                <p class="mb-1 mt-3 text-uppercase text-success">Tác giả : {{$book->author}}</p>
                                <h4 class="mt-3 mb-2">Nội dung</h4>
                                <p class="card-text mb-auto text-center"> {!! \Illuminate\Support\Str::limit($book->sumary,1000) !!} </p>
                                <span class="d-inline-block mb-2 text-primary">
                                    <div class="fb-share-button"
                                         data-href="{{\Illuminate\Support\Facades\URL::current()}}"
                                         data-layout="button_count" data-size="large">
                                        <a target="_blank"
                                           href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
                                           class="fb-xfbml-parse-ignore">Share</a>
                                    </div>
                                   <div class="fb-save" data-uri="{{\Illuminate\Support\Facades\URL::current()}}"
                                        data-size="large"></div>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-2 mb-5">
                            <div class="col-auto">
                                <a class="btn btn-outline-success"><i
                                        class="bi bi-eye-fill"> Lượt xem :</i> {{$book->view}}</a>
                            </div>
                            <div class="col-md-auto">
                                @php
                                    if (\Illuminate\Support\Facades\Auth::check())
                                        {
                                            $theodoi=\Illuminate\Support\Facades\DB::table('likes')->where('id_user','=',\Illuminate\Support\Facades\Auth::user()->id)
                                            ->where('id_book','=',$book->id)->get();
                                        }
                                    $count=$theodoi->count();
                                    $likes=\Illuminate\Support\Facades\DB::table('likes')->get();
                                    $countlikes=$likes->count();
                                @endphp
                                @if($count>0)
                                    <form action="{{route('botheodoi',$book->id)}}" method="post" enctype="multipart/form-data">
                                       @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success"><i
                                                class="bi bi-bookmark-x"> Bỏ yêu thích</i></button>
                                    </form>

                                @else
                                    <form action="{{route('theodoi',$book->id)}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success"><i
                                                class="bi bi-bookmark-heart"></i> Lượt yêu thích {{$countlikes}}</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{--Kiểm tra xem có chapter nào trong sách không--}}
                        @php $count=count($chapter) @endphp
                        <div class="col-auto mb-2">
                            @if($count==0)
                                <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#myModal">Đọc
                                    online</a>
                                <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#myModal">Đọc mới
                                    nhất</a>
                                {{--Modal hiển thị thông báo khi sách không có chapter--}}
                                <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-uppercase" id="exampleModalLabel">Thông
                                                    báo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-uppercase">
                                                Sách đang cập nhật - Đang tiến hành
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                                    Đóng
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a class="btn btn-outline-success" href="{{route('docsach',$first_chapter->id)}}">Đọc
                                    online</a>
                                <a class="btn btn-outline-success" href="{{route('docsach',$lasted_chapter->id)}}">Đọc
                                    mới nhất</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="text-danger"><i class="bi bi-list"></i> Danh sách chương</h4>
                        <ul class="list-group">
                            @if($count==0)
                                <h5 class="ml-5"> Đang cập nhật...</h5>
                            @endif
                            @foreach ($chapter as $chapters)
                                <li class="list-group-item"><a href="{{route('docsach',$chapters->id)}}"
                                                               style="text-decoration: none"
                                                               class="text-dark">{{ $chapters->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h3 class="mt-4 mb-3">Cùng thể loại<span><a href="{{route('bookbytype',$idtype)}}"
                                                    class="btn btn-outline-success text-lowercase"
                                                    style="float: right">view all <i
                        class="bi bi-arrow-right"></i></a> </span></h3>
        <div class="row">
            <div class="owl-carousel owl-theme">
                @foreach($bookoftypes as $item)
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
                                <small class="text-muted"><i class="bi bi-eye"></i> 19999</small>
                                <small class="text-muted"><i class="bi bi-heart"></i> 19999</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <h4 class="mt-2 mb-3"> Thể loại</h4>
        <div class="d-inline-flex">
            @foreach($type as $val)
                <a href="{{route('bookbytype',$val->id)}}"
                   class="btn btn-outline-secondary m-1">{{$val->type_name}}</a>
            @endforeach
        </div>
        <hr>
        @include('layouts.client.footer')
    </div>
@endsection

