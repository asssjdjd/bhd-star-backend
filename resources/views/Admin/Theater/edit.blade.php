@extends('Admin.layouts.admin_main')

@section('title', 'Cập nhật rạp phim')

@section('content')
<div id="app">
    <admin-edit-theater-component></admin-edit-theater-component>
</div>
@vite(['resources/js/app.js'])
@endsection