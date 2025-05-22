@extends('User.main')
@section('content')
<div id="app">
    <movie-schedule-component></movie-schedule-component>
</div>
@vite(['resources/js/app.js'])
@endsection