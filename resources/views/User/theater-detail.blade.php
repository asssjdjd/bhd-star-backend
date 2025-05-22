@extends('User.main')
@section('content')
<div id="app">
    <theater-detail-component></theater-detail-component>
</div>
@vite(['resources/js/app.js'])
@endsection