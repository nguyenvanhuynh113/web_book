@extends('layouts.client')
@section('content')
    <div class="container-fluid col-md-10">
        @include('layouts.client.noibat')
        @include('layouts.client.tatcasach')
        @include('layouts.client.moicapnhat')
        @include('layouts.client.xemnhieu')
        @include('layouts.client.theloai')
        @include('layouts/client.danhmuc')
        @include('layouts.client.footer')
    </div>
@endsection
