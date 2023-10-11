@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Search - Key : {{$tukhoa}}</div>
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
                                <th scope="col">Summary</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="searchResults">
                            @foreach($results as $book)
                                <tr>
                                    <td>{{ $book->name }}</td>
                                    <td>{{ $book->slug }}</td>
                                    <td>{{ Illuminate\Support\Str::limit($book->title, 40) }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{!! Illuminate\Support\Str::limit($book->sumary, 100) !!}</td>
                                    <td><img src="{{ $book->book_photo }}"
                                             style="max-height: 150px; max-width: 100px"></td>
                                    <td>
                                        @if($book->status == 'active')
                                            <span class="text-success">{{ $book->status }}</span>
                                        @else
                                            <span class="text-danger">{{ $book->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a type="button" class="btn btn-outline-success me-1"
                                               href="{{ route('getchap', $book->id) }}"><i
                                                    class="bi bi-list"></i></a>
                                            <a type="button" class="btn btn-outline-primary me-1"
                                               href="{{ route('book.edit', $book->id) }}">Edit</a>
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
    </div>
@endsection
