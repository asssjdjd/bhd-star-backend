@extends('Admin.layouts.admin_main')

@section('title', 'Thêm mới khuyến mãi')

@section('content')
<div id="app">
    <admin-create-promotion-component></admin-create-promotion-component>
</div>
@vite(['resources/js/app.js'])
@endsection
