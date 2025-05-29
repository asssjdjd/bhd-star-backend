@extends('User.main')
@section('content')
<div id="app">
    <theater-schedule-detail-component></theater-schedule-detail-component>
</div>
@vite(['resources/js/app.js'])
@endsection
