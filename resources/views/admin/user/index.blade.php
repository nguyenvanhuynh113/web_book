@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('List User') }}</div>
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
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user as $key =>$val)
                                <tr>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->email}}</td>
                                    <td>{{$val->role}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Button to trigger the modal -->
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#userModal_{{$val->id}}">
                                                View User
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="userModal_{{$val->id}}" tabindex="-1"
                                                 aria-labelledby="userModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="userModalLabel">User
                                                                Information</h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Place user information here -->
                                                            <!-- Example: -->
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <!-- User's profile image -->
                                                                    <img src="{{$val->user_photo}}" alt="User Image"
                                                                         class="img-fluid">
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <p><i class="bi bi-person"></i> {{$val->name}}</p>
                                                                    <p><i class="bi bi-send"></i> {{$val->email}}</p>
                                                                    <!-- Add more user details as needed -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
