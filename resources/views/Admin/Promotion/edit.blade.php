@extends('Admin.layouts.admin_main')

@section('title', 'Cập nhật khuyễn mãi')

@section('content')
<div id="app">
    <admin-edit-promotion-component></admin-edit-promotion-component>
</div>
@vite(['resources/js/app.js'])
@endsection