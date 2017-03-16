@extends('layouts.main')

@section('title', 'Account settings | Ping the People')

@section('content')
    <div class="row">
        <div class="eight columns offset-by-two">
            <div class="account">
                <h1 class="section-title">Account settings for {{$user->Name}}</h1>

                <form action="/account/save" method="post">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{csrf_field()}}
                    <label for="name">Name</label>
                    <input type="text" value="{{$user->Name}}" id="name" name="Name">

                    <label for="email">Email</label>
                    <input type="email" value="{{$user->Email}}" id="email" name="Email">

                    <div class="account__submit">
                        <input type="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection