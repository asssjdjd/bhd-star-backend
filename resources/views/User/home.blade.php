@extends('User.main')
@section('content')
<div id="app">
    <home-component></home-component>
    {{-- <login-component></login-component> --}}
</div>
@vite(['resources/js/app.js'])
@endsection