@extends('User.main')
@section('content')
<div id="app">
    <reset-password-component></reset-password-component>
    {{-- <login-component></login-component> --}}
</div>
@vite(['resources/js/app.js'])
@endsection
