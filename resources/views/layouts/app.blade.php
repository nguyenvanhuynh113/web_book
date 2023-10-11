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
            background-color: #b4ffb8;
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
                @guest
                    <ul class="navbar-nav ms-auto navbar-nav-scroll"
                        style="--bs-scroll-height: 100px;">
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    </ul>
                @else
                    <a class="navbar-brand" href="#">Admin Page</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarScroll"
                            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll"
                            style="--bs-scroll-height: 100px;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                   href="{{\Illuminate\Support\Facades\URL::to('/admin')}}">Dashboard</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Category
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                    <li><a class="dropdown-item" href="{{route('category.index')}}">List categories</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{route('category.create')}}">Add category</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Type
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                    <li><a class="dropdown-item" href="{{route('type.index')}}">List types</a></li>
                                    <li><a class="dropdown-item" href="{{route('type.create')}}">Add type</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    Book
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                    <li><a class="dropdown-item" href="{{route('book.index')}}">List books</a></li>
                                    <li><a class="dropdown-item" href="{{route('book.create')}}">Add book</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    User
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                                    <li><a class="dropdown-item" href="{{route('user.index')}}">List users</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="search-container">
                            <form class="d-flex" action="{{route('adminsearch')}}" method="GET">
                                <input autocomplete="off" class="form-control me-2 col-md-6 f" type="search"
                                       id="searchInput"
                                       placeholder="Nhập từ khóa..."
                                       name="tukhoa"
                                       aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                            <ul id="searchSuggestionsList" class="list-group"></ul>
                        </div>
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
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <a class="dropdown-item" href="">Profile</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          class="d-none">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{\Illuminate\Support\Facades\URL::to('/')}}">Go to
                                        client</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </nav>
    </div>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<!-- choose one -->
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
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
            if (query.length >0) {
                $.ajax({
                    url: '/goiy',
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (response) {
                        // Khi nhận được phản hồi thành công, hiển thị các gợi ý bằng cách gọi hàm showSuggestions(response);
                        showSuggestions(response);
                    }
                });
            }
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
</body>
</html>
