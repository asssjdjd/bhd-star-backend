@extends('User.main')
@section('content')
<div id="app">
    <shop-component></shop-component>
</div>
@vite(['resources/js/app.js'])
@endsection