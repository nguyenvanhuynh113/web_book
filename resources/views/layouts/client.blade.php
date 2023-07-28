<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Nạp Owl Carousel -->

    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <style>
        .search-container {
            position: relative;
        }

        #searchSuggestionsList {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            width: 100%;
            border: 1px solid #ced4da;
            border-top: 0;
            border-radius: 0 0 0.25rem 0.25rem;
            background-color: #fff;
            display: block;
        }

        .search-item {
            padding: 0.5rem;
            cursor: pointer;
        }

        .search-item:hover {
            background-color: #f8f9fa;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="bi bi-book"></i> TruyenSach.com</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll"
                        style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="{{\Illuminate\Support\Facades\URL::to('/')}}"><i class="bi bi-house"></i> Trang chủ</a>
                        </li>
                        @php
                            $category=DB::table('categories')->where('status','active')->orderByDesc('created_at')->get();
                            $type=DB::table('types')->where('status','active')->orderByDesc('created_at')->get();
                        @endphp
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-list"></i> Danh mục
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                @foreach($category as $val)
                                    <li><a class="dropdown-item "
                                           href="{{route('bookbycat',$val->id)}}">{{$val->category_name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-tags"></i> Thể loại
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                @foreach($type as $val)
                                    <li><a class="dropdown-item"
                                           href="{{route('bookbytype',$val->id)}}">{{$val->type_name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                               href="#"><i class="bi bi-newspaper"></i> Blog</a>
                        </li>
                    </ul>
                    <div class="search-container">
                        <form class="d-flex" action="{{route('timkiem')}}" method="GET">
                            <input autocomplete="off" class="form-control me-2 col-md-6 f" type="search"
                                   id="searchInput"
                                   placeholder="Nhập từ khóa..."
                                   name="tukhoa"
                                   aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>

                        </form>
                        <ul id="searchSuggestionsList" class="list-group"></ul>
                    </div>
                    @guest
                        <ul class="navbar-nav ms-auto navbar-nav-scroll"
                            style="--bs-scroll-height: 100px;">
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"><i
                                            class="bi bi-person"></i>{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"><i
                                            class="bi bi-lock"></i>{{ __('Register') }}</a>
                                </li>
                            @endif
                        </ul>
                    @else
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                            class="bi bi-box-arrow-in-right"></i>
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="{{route('profile', Auth::user()->id)}}"> <i
                                            class="bi bi-person"></i> Profile</a>
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myModal"><i
                                            class="bi bi-heart"></i> Theo dõi</a>
                                    <!-- Modal thông báo -->
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                    @if(\Illuminate\Support\Facades\Auth::user()->role=='admin')
                                        <a class="dropdown-item"
                                           href="{{\Illuminate\Support\Facades\URL::to('/admin')}}"> <i
                                                class="bi bi-arrow-right"></i> Go to admin </a>
                                    @endif

                                </div>
                            </li>
                        </ul>
                    @endguest

                </div>
            </div>
        </nav>
    </div>
    <main class="py-4">
        @php
            if(\Illuminate\Support\Facades\Auth::check())
                {
                    $user=\App\Models\User::find(\Illuminate\Support\Facades\Auth::user()->id);
                    $theodoi=$user->likes()->where('status', 'active')->orderByDesc('created_at')->paginate(5);
                    $count_theodoi=$theodoi->count();
                }
        @endphp
        @guest
        @else
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Danh sách theo dõi - Số lượng
                                : {{$count_theodoi}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                @foreach($theodoi as $item => $val)
                                    <li class="list-group-item mb-2">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="{{$val->book_photo}}" alt="Sản phẩm 1"
                                                     class="img-fluid rounded"  style="max-height: 100px;max-width: 70px">
                                            </div>
                                            <div class="col-md-9">
                                                <h4 class="mb-3"><a href="{{route('xemsach',$val->id)}}"style="text-decoration: none"
                                                    class="text-success">{{$val->name}}</a></h4>
                                                <p>{!! \Illuminate\Support\Str::limit($val->sumary,50) !!}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                <!-- Thêm các mục sản phẩm khác vào đây -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endguest
        @yield('content')
    </main>
</div>
<!-- choose one -->
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 6,
            nav: true,
            dots: true, // Bật hiển thị dots
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 6
                }
            }
        });
    });
</script>

<script>
    function showSuggestions(suggestions) {
        var suggestionsList = $('#searchSuggestionsList');
        suggestionsList.empty();

        $.each(suggestions, function (index, suggestion) {
            var listItem = $('<li class="list-group-item"></li>');
            listItem.text(suggestion);
            suggestionsList.append(listItem);
        });
    }

    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
            var query = $(this).val();
            $.ajax({
                url: '/search_suggestions',
                method: 'GET',
                data: {query: query},
                dataType: 'json',
                success: function (response) {
                    showSuggestions(response);
                }
            });
        });
        $('#searchSuggestionsList').on('click', '.list-group-item', function () {
            var selectedSuggestion = $(this).text();
            $('#searchInput').val(selectedSuggestion);
            $('#searchSuggestionsList').empty();
        });
    });
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0"
        nonce="XShbigi6"></script>
</body>
</html>
