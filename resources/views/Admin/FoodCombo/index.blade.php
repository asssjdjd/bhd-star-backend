@extends('Admin.layouts.admin_main')

@section('title', 'Quản Lý Combo Đồ Ăn')

@section('content')
<div id="app">
    <admin-foodcombo-component></admin-foodcombo-component>
</div>
@vite(['resources/js/app.js'])
@endsection