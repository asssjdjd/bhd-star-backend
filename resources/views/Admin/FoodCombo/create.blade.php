@extends('Admin.layouts.admin_main')

@section('title', 'Thêm mới combo đồ ăn')

@section('content')
<div id="app">
    <admin-create-foodcombo-component></admin-create-foodcombo-component>
</div>
@vite(['resources/js/app.js'])
@endsection