@extends('Admin.layouts.admin_main')
@section('title', 'Quản Lý rạp')
@section('content')
    <div id="app">
        <admin-showtime-component></admin-showtime-component>
    </div>
@vite(['resources/js/app.js'])
@endsection

