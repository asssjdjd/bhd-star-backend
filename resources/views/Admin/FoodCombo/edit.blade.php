@extends('Admin.layouts.admin_main')

@section('title', 'Cập nhật Combo đồ ăn')

@section('content')
<div id="app">
    <admin-edit-foodcombo-component></admin-edit-foodcombo-component>
</div>
@vite(['resources/js/app.js'])
@endsection