@extends('User.main')
@section('content')
<div id="app">
    <user-detail-component></user-detail-component>
</div>
@vite(['resources/js/app.js'])
@endsection
