@extends('Admin.layouts.admin_main')

@section('title', 'Quản Lý Rạp Phim')

@section('content')
<div id="app">
    <admin-theater-component></admin-theater-component>
</div>
@vite(['resources/js/app.js'])
@endsection