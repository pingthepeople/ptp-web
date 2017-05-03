@extends('layouts.guest')

@section('title', '500 error | Ping the People')

@section('content')

    @include('shared.guest-header')

    <div class="container">
        <div class="http-error-page">

            <h1 class="section-title">Sorry, something went wrong</h1>
            <p>500 error</p>
        </div>
    </div>

@endsection