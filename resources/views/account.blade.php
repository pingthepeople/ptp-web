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

                    <label for="email">Email Address for Alerts</label>
                    <input type="email" value="{{$user->Email}}" id="email" name="Email">

                    <label for="mobile">Mobile Number for Alerts</label>
                    <input type="tel" value="{{$user->Mobile}}" id="mobile" name="Mobile">

                    <fieldset>
                        <legend>Daily legislative roundup</legend>
                        <p>In addition to instant updates, we can send you a daily roundup of legislative activity. You can receive a roundup of all legislation, or just the items on your watchlist.</p>
                        <label for="none"><input type="radio" name="DigestType" id="none" value="0" {{$user->DigestType==0 ? 'checked' : ''}}> I don't want to receive this.</label>
                        <label for="myBills"><input type="radio" name="DigestType" id="myBills" value="1" {{$user->DigestType==1 ? 'checked' : ''}}> Send me a roundup of the items on my watchlist.</label>
                        <label for="allBills"><input type="radio" name="DigestType" id="allBills" value="2" {{$user->DigestType==2 ? 'checked' : ''}}> Send me a roundup of all legislation.</label>
                    </fieldset>

                    <div class="account__submit">
                        <input type="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection