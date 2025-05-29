@extends('Admin.layouts.admin_main')

@section('title', 'Thêm mới rạp phim')

@section('content')
<div id="app">
    <admin-create-theater-component></admin-create-theater-component>
</div>
@vite(['resources/js/app.js'])
@endsection