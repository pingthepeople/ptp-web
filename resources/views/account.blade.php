@extends('layouts.main')

@section('title', 'Account settings | Ping the People')

@section('content')
    <div class="row">
        <div class="eight columns offset-by-two">
            <div class="account">
                <h1 class="section-title">Account settings for {{$user->Name}}</h1>

                <form action="/account/save" method="post">
                    {{csrf_field()}}
                    
                </form>
            </div>
        </div>
    </div>

@endsection