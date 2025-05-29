@extends('Admin.layouts.admin_main')

@section('title', 'Quản Lý Danh Mục')

@section('content')
<div id="app">
    <category-component></category-component>
</div>
@vite(['resources/js/app.js'])
@endsection