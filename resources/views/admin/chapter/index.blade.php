@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title btn">List chapter</span>
                        <span><a href="{{route('chapter.create')}}" class="card-title btn btn-outline-success" style="float: right"> Add chapter</a></span>
                    </div>
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
                                <th scope="col">Content</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chapter as $key =>$val)
                                <tr>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->slug}}</td>
                                    <td>{{$val->title}}</td>
                                    <td>{{\Illuminate\Support\Str::limit($val->content,100) }}</td>
                                    <td>@if($val->status=='active')<span class="text-success">{{$val->status}}
                                            </span>@else<span class="text-danger">{{$val->status}}</span> @endif</td>
                                    <td>
                                        <div class="btn-group" role="group" >
                                            <button type="button" class="btn btn-danger me-1" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal">
                                                Delete
                                            </button>
                                            <div class="modal fade" id="confirmModal" tabindex="-1"
                                                 aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmModalLabel">Confirm
                                                                Delete</h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this chapter ?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <form action="{{ route('chapter.destroy', $val->id) }}"
                                                                  method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a type="button" class="btn btn-warning" href="{{route('chapter.edit',$val->id)}}">Edit</a>
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
