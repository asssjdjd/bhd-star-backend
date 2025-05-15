@extends('Admin.layouts.admin_main')

@section('title', 'Thêm Mới Danh Mục')

@section('content')
<div id="app">
    <edit-film-component></edit-film-component>
</div>
@vite(['resources/js/app.js'])
@endsection