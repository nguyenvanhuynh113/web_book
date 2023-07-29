@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('List Books') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Sumary</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($books as $key =>$val)
                                <tr>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->slug}}</td>
                                    <td>{{\Illuminate\Support\Str::limit($val->title,40)}}</td>
                                    <td>{{$val->author}}</td>
                                    <td>{!!\Illuminate\Support\Str::limit($val->sumary,100) !!}</td>
                                    <td><img src="{{$val->book_photo}}" style="max-height:150px;max-width: 100px"></td>
                                    <td>@if($val->status=='active')
                                            <span class="text-success">{{$val->status}}
                                            </span>
                                        @else
                                            <span class="text-danger">{{$val->status}}</span>
                                        @endif</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a type="button" class="btn btn-outline-success me-1" href="{{route('getchap',$val->id)}}"><i class="bi bi-list"></i></a>
                                            <a type="button" class="btn btn-outline-primary me-1" href="{{route('book.edit',$val->id)}}">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
