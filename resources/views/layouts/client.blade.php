<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .button-container {
            display: flex;
            flex-wrap: wrap;
        }

        .btn {
            display: block;
            text-align: center;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.1);
        }

        /* CSS để đặt chiều cao cố định và chiều rộng tự động cho các ảnh trong carousel */
        .owl-carousel .card-img-top {
            height: 300px; /* Đặt chiều cao cố định, thay đổi giá trị tùy ý */
            width: auto; /* Chiều rộng tự động sẽ giữ nguyên tỷ lệ khung hình */
        }

        /* Đảm bảo ảnh trong card có chiều cao tối đa và tỷ lệ khung hình giữ nguyên */
        .owl-carousel .card-img-top {
            max-height: 100%;
            object-fit: cover;
        }
    </style>
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

        .list-group-item {
            padding: 0.5rem;
            cursor: pointer;
        }

        .list-group-item:hover {
            background-color: #a7f6cf;
        }

        /* CSS để đặt chiều cao cố định và chiều rộng tự động cho các ảnh trong carousel */
        .owl-carousel .card-img-top {
            height: 220px; /* Đặt chiều cao cố định, thay đổi giá trị tùy ý */
            width: auto; /* Chiều rộng tự động sẽ giữ nguyên tỷ lệ khung hình */
        }

        /* Đảm bảo ảnh trong card có chiều cao tối đa và tỷ lệ khung hình giữ nguyên */
        .owl-carousel .card-img-top {
            max-height: 100%;
            object-fit: cover;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <div class="container fixed-top">
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
                                                     class="img-fluid rounded"
                                                     style="max-height: 100px;max-width: 70px">
                                            </div>
                                            <div class="col-md-9">
                                                <h4 class="mb-3"><a href="{{route('xemsach',$val->id)}}"
                                                                    style="text-decoration: none"
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
    // Chờ cho đến khi toàn bộ tài liệu HTML đã được tải xong và sẵn sàng để sử dụng
    $(document).ready(function () {
        // Chọn tất cả các phần tử có lớp 'owl-carousel' và áp dụng plugin Owl Carousel lên chúng
        $('.owl-carousel').owlCarousel({
            // Vòng lặp vô hạn trong carousel, khi đến cuối danh sách thì quay lại đầu
            loop: true,
            // Khoảng cách giữa các mục trong carousel
            margin: 4,
            // Hiển thị nút điều hướng (nút trước và nút sau) để chuyển đổi giữa các mục
            nav: true,
            // Hiển thị chấm chỉ thị để biểu thị vị trí hiện tại trong carousel
            dots: true, // Bật hiển thị dots
            // Tự động chuyển đổi giữa các mục trong carousel
            autoplay: true,
            // Thời gian chờ giữa các lần chuyển đổi tự động (đơn vị: miliseconds)
            autoplayTimeout: 3000,
            // Tạm dừng tự động chuyển đổi khi người dùng di chuột qua carousel
            autoplayHoverPause: true,
            // Thiết lập số lượng mục hiển thị tại các kích thước màn hình khác nhau
            responsive: {
                0: {
                    // Khi màn hình nhỏ hơn hoặc bằng 0px, hiển thị 2 mục trên mỗi slide
                    items: 4
                },
                600: {
                    // Khi màn hình nhỏ hơn hoặc bằng 600px, hiển thị 4 mục trên mỗi slide
                    items: 6
                },
                1000: {
                    // Khi màn hình nhỏ hơn hoặc bằng 1000px, hiển thị 6 mục trên mỗi slide
                    items: 8
                }
            }
        });
    });
</script>
<!-- JavaScript -->
<script>
    // Hàm hiển thị các gợi ý tìm kiếm
    function showSuggestions(suggestions) {
        // Lấy phần tử HTML có id="searchSuggestionsList" để hiển thị các gợi ý
        var suggestionsList = $('#searchSuggestionsList');
        suggestionsList.empty(); // Làm sạch phần tử để chuẩn bị hiển thị gợi ý mới

        // Lấy giá trị từ ô tìm kiếm và chuẩn hóa để so sánh (bỏ dấu và đưa về chữ thường)
        var userInput = $('#searchInput').val().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

        // Mảng để lưu trữ các gợi ý duy nhất
        var uniqueSuggestions = [];

        // Duyệt qua từng gợi ý trong danh sách 'suggestions'
        $.each(suggestions, function (index, suggestion) {
            // Chuẩn hóa các giá trị gợi ý để so sánh (bỏ dấu và đưa về chữ thường)
            var category = suggestion.category_name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            var type = suggestion.type_name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            var book = suggestion.name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            var author = suggestion.author.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

            // Kiểm tra xem chuỗi người dùng nhập bắt đầu gần giống với các gợi ý và không trùng với gợi ý
            if (
                (category.startsWith(userInput) && category !== userInput) ||
                (type.startsWith(userInput) && type !== userInput) ||
                (book.startsWith(userInput) && book !== userInput) ||
                (author.startsWith(userInput) && author !== userInput)
            ) {
                // Nếu gợi ý không tồn tại trong mảng duy nhất, thì hiển thị và thêm vào mảng duy nhất
                if (!uniqueSuggestions.includes(suggestion.category_name)) {
                    if (category) {
                        var categoryItem = $('<li class="list-group-item"></li>');
                        categoryItem.text(suggestion.category_name);
                        suggestionsList.append(categoryItem);
                        uniqueSuggestions.push(suggestion.category_name);
                    }
                }

                if (!uniqueSuggestions.includes(suggestion.type_name)) {
                    if (type) {
                        var typeItem = $('<li class="list-group-item"></li>');
                        typeItem.text(suggestion.type_name);
                        suggestionsList.append(typeItem);
                        uniqueSuggestions.push(suggestion.type_name);
                    }
                }

                if (!uniqueSuggestions.includes(suggestion.name)) {
                    if (book) {
                        var bookItem = $('<li class="list-group-item"></li>');
                        bookItem.text(suggestion.name);
                        suggestionsList.append(bookItem);
                        uniqueSuggestions.push(suggestion.name);
                    }
                }

                if (!uniqueSuggestions.includes(suggestion.author)) {
                    if (author) {
                        var authorItem = $('<li class="list-group-item"></li>');
                        authorItem.text(suggestion.author);
                        suggestionsList.append(authorItem);
                        uniqueSuggestions.push(suggestion.author);
                    }
                }
            }
        });
    }

    $(document).ready(function () {
        // Lắng nghe sự kiện 'keyup' trên ô tìm kiếm với id="searchInput"
        $('#searchInput').on('keyup', function () {
            var query = $(this).val();
            // Gửi yêu cầu AJAX để lấy danh sách các gợi ý phù hợp từ server
            $.ajax({
                url: '/search_suggestions',
                method: 'GET',
                data: {query: query},
                dataType: 'json',
                success: function (response) {
                    // Khi nhận được phản hồi thành công, hiển thị các gợi ý bằng cách gọi hàm showSuggestions(response);
                    showSuggestions(response);
                }
            });
        });
        // Lắng nghe sự kiện 'click' trên các phần tử 'li' trong 'searchSuggestionsList'
        $('#searchSuggestionsList').on('click', '.list-group-item', function () {
            // Khi người dùng chọn một gợi ý, đưa giá trị của gợi ý đó vào ô tìm kiếm và làm sạch danh sách gợi ý
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
