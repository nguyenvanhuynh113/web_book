<style>
    /* Đảm bảo chiều cao của card trong carousel bằng nhau */
    .row-cols-1 .col-md-2 {
        flex: 0 0 12.5%;
        max-width: 12.5%;
        padding: 0;
    }

    /* Đảm bảo chiều cao của card bằng nhau */
    .card {
        height: 100%;
        min-height: 300px; /* Điều chỉnh chiều dài của card tại đây */
    }

    /* Đảm bảo chiều cao của hình ảnh bằng nhau */
    .card img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    /* Hiển thị 8 cột trong một hàng */
    @media (min-width: 1200px) {
        /* breakpoint >= 1200px (màn hình lớn) */
        .row-cols-7 .col-md-2 {
            flex: 0 0 12.5%;
            max-width: 12%;
            padding: 0;
            margin-left: 5px; /* Thêm margin 10px dưới mỗi item */
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        /* breakpoint từ 992px đến 1199px (màn hình trung bình) */
        .row-cols-7 .col-md-2 {
            flex: 0 0 25%;
            max-width: 11.1111%;
            padding: 0;
            margin-left: 10px; /* Thêm margin 10px dưới mỗi item */
        }
    }

    @media (max-width: 991px) {
        /* breakpoint < 991px (màn hình nhỏ) */
        .row-cols-7 .col-md-2 {
            flex: 0 0 33.3333333%;
            max-width: 33.3333333%;
            padding: 0;
            margin-left: 10px; /* Thêm margin 10px dưới mỗi item */
        }
    }
</style>
<h3 class="mt-2  mb-4">Tất cả</h3>
<div class="row">
    <div class="album bg-light">
        <div class="container">
            <div class="row row-cols-7 g-2"> <!-- Sử dụng row-cols-7 để hiển thị 7 cột trong một hàng -->
                @foreach($all as $item)
                    <div class="col-md-2 mb-4"> <!-- Sử dụng col-md-2 để mỗi item chiếm 1/7 chiều rộng của màn hình -->
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" style="max-height: 300px"
                                 src="{{$item->book_photo}}" role="img" aria-label="Placeholder: Thumbnail"
                                 preserveAspectRatio="xMidYMid slice" focusable="false"><title>
                                Placeholder</title>
                            </img>
                            <div class="card-body">
                                <p class="card-text text-success" style="height: 40px">{{\Illuminate\Support\Str::limit($item->name,20)}}</p>
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
                <div class="d-flex justify-content-center ">
                    {{ $book->links('client/pagination/custom') }}
                </div>
            </div>
        </div>
    </div>
</div>
