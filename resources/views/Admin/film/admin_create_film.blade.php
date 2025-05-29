@extends('Admin.layouts.admin_main')

@section('title', 'Thêm Mới Phim')

@section('content')
<div id="app">
    <create-film-component></create-film-component>
</div>
@vite(['resources/js/app.js'])
@endsection