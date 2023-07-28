@extends('layouts.client')
<style>
    /* Custom CSS */
    body {
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    .user-profile {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .user-profile img {
        max-width: 200px;
        border-radius: 50%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .user-profile h2 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #333;
    }

    .user-profile p {
        color: #666;
    }

    .user-details {
        padding: 20px;
    }

    .user-details h3 {
        color: #555;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
    }

    .user-details ul {
        list-style: none;
        padding-left: 0;
    }

    .user-details ul li {
        margin-bottom: 10px;
    }

    .user-details ul li strong {
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .social-icons a {
        color: #555;
        font-size: 20px;
        margin-right: 10px;
        transition: color 0.3s;
    }

    .social-icons a:hover {
        color: #007bff;
    }
</style>
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 user-profile">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <!-- User's profile image -->
                        <img src="{{$users->user_photo}}" alt="User Image" class="img-fluid">
                            <a type="submit" class="btn btn-outline-dark mt-3" onclick="openImageUploader()">Choose file
                            </a>
                        <h2>{{$users->name}}</h2>
                        <p class="text-muted">{{$users->email}}</p>
                        <div class="social-icons">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="col-md-8 user-details">
                        <!-- User's details -->
                        <h3>About Me</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac suscipit dui. Vestibulum
                            tincidunt quam vel elit convallis ullamcorper. Integer luctus dictum leo, eu aliquam dolor
                            scelerisque in. Suspendisse potenti. Maecenas ac mauris eu purus vulputate suscipit.</p>

                        <h3>Education</h3>
                        <ul>
                            <li>University of XYZ, Computer Science, Bachelor's Degree</li>
                        </ul>

                        <h3>Work Experience</h3>
                        <ul>
                            <li>ABC Software Company - Senior Software Engineer (2018 - Present)</li>
                            <li>XYZ Tech Solutions - Software Engineer (2015 - 2018)</li>
                        </ul>
                        <h3></h3>
                        <ul>
                            <form action="{{route('capnhatuser',$users->id)}}" method="post" enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                <input type="file" id="imageUploader" style="display: none;" name="file">
                                <button type="submit" class="btn btn-primary ms-auto">Cập nhật</button>
                            </form>
                            <script>
                                function openImageUploader() {
                                    document.getElementById('imageUploader').click();
                                }

                                document.getElementById('imageUploader').addEventListener('change', function () {
                                    var file = this.files[0];
                                    var reader = new FileReader();

                                    reader.onloadend = function () {
                                        var image = document.createElement('img');
                                        image.src = reader.result;
                                        image.className = 'img-fluid rounded-circle mb-3';
                                        document.querySelector('.col-md-4 img').replaceWith(image);
                                    }
                                    if (file) {
                                        reader.readAsDataURL(file);
                                    }
                                });
                            </script>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
