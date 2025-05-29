@extends('Admin.layouts.admin_main')

@section('title', 'Quản Lý Khuyến Mãi')

@section('content')
<div id="app">
    <admin-promotion-component></admin-promotion-component>
</div>
@vite(['resources/js/app.js'])
@endsection