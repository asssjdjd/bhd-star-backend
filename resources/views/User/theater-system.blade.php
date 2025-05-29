@extends('User.main')
@section('content')
<div id="app">
    <theater-component></theater-component>
</div>
@vite(['resources/js/app.js'])
@endsection
