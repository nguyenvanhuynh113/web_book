@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add Book') }}</div>
                    <div class="card-body">
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
                        <form action="{{route('book.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control" id="title" name="name" value="{{old('name')}}"
                                       placeholder="Book name"
                                       onkeyup="ChangeToSlug();">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Title</label>
                                <input type="text" class="form-control" id="exampleInputPassword1" name="title"
                                       value="{{old('title')}}"
                                       placeholder="Title">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Author</label>
                                <input type="text" class="form-control" name="author" placeholder="Author name"
                                       value="{{old('author')}}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Sumary</label>
                                <textarea class="form-control" name="content" value="{{old('content')}}" id="content"
                                          style="resize: none;height: 150px"
                                          placeholder="Book content summary..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Book image</label>
                                <input type="file" class="form-control" required name="book_photo"
                                       value="{{old('book_photo')}}">
                            </div>

                            <div class="mb-3 form-check form-check-inline form-control">
                                <label class="form-label text-uppercase text-bold d-block">Category</label>
                                @foreach($category as $key)
                                    <input type="checkbox" name="category[]" class="btn-check"
                                           id="category_{{$key->id}}"
                                           autocomplete="off" value="{{$key->id}}">
                                    <label class="btn btn-outline-success mb-1"
                                           for="category_{{$key->id}}">{{$key->category_name}}</label>
                                @endforeach
                            </div>
                            <div class="mb-3 form-check form-check-inline form-control">
                                <label class="form-label text-uppercase text-bold d-block">Type</label>
                                @foreach($type as $key)
                                    <input type="checkbox" name="type[]" value="{{$key->id}}" class="btn-check"
                                           id="type_{{$key->id}}"
                                           autocomplete="off">
                                    <label class="btn btn-outline-success mb-1"
                                           for="type_{{$key->id}}">{{$key->type_name}}</label>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" aria-label="Default select example" name="status">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary col-md-1">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function ChangeToSlug() {
            var title, slug;

            //Lấy text từ thẻ input title
            title = document.getElementById("title").value;

            //Đổi chữ hoa thành chữ thường
            slug = title.toLowerCase();

            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('slug').value = slug;
        }
    </script>
@endsection

