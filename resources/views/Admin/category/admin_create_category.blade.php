@extends('Admin.layouts.admin_main')

@section('title', 'Quản Lý Danh Mục')

@section('content')
<div id="app">
    <create-category-component></create-category-component>
</div>
@vite(['resources/js/app.js'])
@endsection