@extends('layouts.client')
<style xmlns="">
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 600px;
    }

    #article-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-container {
        text-align: center;
        margin-top: 20px;
    }

    .slider-container {
        margin-bottom: 10px;
    }
</style>
@section('content')
    <div class="container">
        <h3 class="mt-3 text-uppercase"><i class="bi bi-arrow-right"></i>
            <a href="{{route('xemsach',$book->id)}}"
               style="text-decoration: none;"> {{$book->name}} </a>/ {{$chapter->name}}</h3>
        <div class="container py-4">
            <div class="row">
                <div class="btn-container">
                    <button id="readButton" class="btn btn-outline-success ms-auto mt-3" onclick="readArticle()">
                        <i class="bi bi-play"></i>
                    </button>
                    <button id="pauseButton" class="btn btn-outline-success ms-auto mt-3 " onclick="pauseSpeech()">
                        <i class="bi bi-pause"></i>
                    </button>
                    <button id="resumeButton" class="btn btn-outline-success ms-auto mt-3" onclick="resumeSpeech()">
                        <i class="bi bi-skip-forward"></i>
                    </button>
                    <button id="stopButton" class="btn btn-outline-success ms-auto mt-3" onclick="stopSpeech()"
                            disabled>
                        <i class="bi bi-stop"></i>
                    </button>
                </div>
                <div class="col-md-12">
                    <div id="article-container">
                        <p>{!! $chapter->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <script src='https://code.responsivevoice.org/responsivevoice.js?key=AN1jc0tp'/>
        </script>
        <script>
            var isSpeaking = false;

            function readArticle() {
                var articleContent = document.getElementById("article-container").textContent;
                var rate = 1;
                var volume = 1;

                responsiveVoice.cancel(); // Dừng giọng nói trước khi bắt đầu

                // Tổng hợp giọng nói cho nội dung của phần tử "article-container"
                responsiveVoice.speak(articleContent, 'Vietnamese Female', {
                    rate: rate,
                    volume: volume,
                    onstart: function () {
                        isSpeaking = true;
                        document.getElementById('stopButton').disabled = false;
                        document.getElementById('resumeButton').disabled = true;
                        document.getElementById('pauseButton').disabled = false;
                    },
                    onend: function () {
                        isSpeaking = false;
                        document.getElementById('stopButton').disabled = true;
                    }
                });
            }

            function stopSpeech() {
                responsiveVoice.cancel(); // Dừng giọng nói
                isSpeaking = false;
                document.getElementById('stopButton').disabled = true;
                document.getElementById('pauseButton').disabled = true;
                document.getElementById('resumeButton').disabled = true;
            }

            function pauseSpeech() {
                responsiveVoice.pause(); // tam dừng giọng nói
                isSpeaking = false;
                document.getElementById('pauseButton').disabled = true;
                document.getElementById('resumeButton').disabled = false;
                document.getElementById('readButton').disabled = true;
            }

            function resumeSpeech() {
                responsiveVoice.resume();// tiep tuc giong noi
                document.getElementById('pauseButton').disabled = false;
                document.getElementById('resumeButton').disabled = true;
                document.getElementById('readButton').disabled = false;
            }
        </script>
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
    </div>
@endsection
