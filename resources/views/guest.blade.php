@extends('layouts.guest')

@section('title', 'Ping the People')

@section('content')
    <div class="guest-welcome">
        <h1>Welcome to <span class="logo">Ping the People</span></h1>

        <a class="button button--fb" href="{{url('/login-via-facebook')}}">Login with Facebook</a>

        <a class="button button--google" href="{{url('/login-via-google')}}">Login with Google</a>
    </div>
@endsection