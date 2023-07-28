@extends('layouts.client')
@section('content')
    <div class="container">
        <h3 class="mt-3 text-uppercase"><i class="bi bi-arrow-right"></i> <a href="{{route('xemsach',$book->id)}}"
                                                                             style="text-decoration: none;"> {{$book->name}} </a>
            / {{$chapter->name}}</h3>
        <div class="container">
            <div class="card-body">
                <p>{!! $chapter->content !!}</p>
            </div>
        </div>

        <!-- Liên kết "Next" để chuyển đến chương tiếp theo -->
        <div class="row mt-4 mb-4 justify-content-center align-items-center">
            <div class="col-auto">
                @if($preChapter)
                    <a href="{{ route('docsach', $preChapter->id) }}" class="btn btn-outline-success">Previous</a>
                @else
                    <a class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#myModal">Previous</a>
                @endif
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    {{$chapter->name}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach($listchap as $item)
                        <li><a class="dropdown-item" href="{{route('docsach',$item->id)}}">{{$item->name}}</a></li>
                    @endforeach
                </ul>
                @if ($nextChapter)
                    <a href="{{ route('docsach', $nextChapter->id) }}" class="btn btn-outline-success">Next</a>
                @else
                    <a class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#myModal">Next</a>
                @endif
            </div>
        </div>
        {{--Modal hiển thị thông báo khi người dùng click vào chức năng bị vô hiệu--}}
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
                        Đã hết chương
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="fb-comments" data-href="{{\Illuminate\Support\Facades\URL::current()}}" data-width="100%"
             data-numposts="10"></div>
        <hr>
        <h4 class="mt-2 mb-3">The Loai Truyen-Sach</h4>
        <div class="d-inline-flex">
            @foreach($type as $val)
                <a href="{{route('bookbytype',$val->id)}}"
                   class="btn btn-outline-secondary m-1">{{$val->type_name}}</a>
            @endforeach
        </div>
        <hr>
    @include('layouts.client.footer')
@endsection
