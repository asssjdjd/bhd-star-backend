@extends('User.main')
@section('content')
<div id="app">
    <theater-schedule-component></theater-schedule-component>
</div>
@vite(['resources/js/app.js'])
@endsection
