@extends('layouts.main')

@section('title', 'Account settings | Ping the People')

@section('content')
    <div class="content-wrapper">
        <h1 class="section-title">Account settings for {{$user->Name}}</h1>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success-message'))
            <div class="alert alert-success">
                {{session('success-message')}}
            </div>
        @endif
        <div class="account">
            <div class="account__notifications">
                <h2 class="">Notifications</h2>
                <form action="/account/save" method="post">
                    {{csrf_field()}}
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
                        <input type="submit" value="Save account settings">
                    </div>
                </form>
            </div>

            <div class="account__legislators">
                <h2>My legislators</h2>

                <p>Setting your legislator will help identify legislation that they are involved in. Enter your address, city, and zip to locate your legislator, or select them below.</p>

                <form action="/account/find-my-legislator" method="post">
                    {{csrf_field()}}
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city">
                    <label for="zip">Zip code</label>
                    <input type="text" id="zip" name="zip">

                    <input type="submit" value="Look up">
                </form>

                <hr>

                <form class="" action="/account/save" method="post">
                    {{csrf_field()}}
                    <label for="representative">House representative</label>
                    <select id="representative" name="RepresentativeId">
                        <option value=''>-- not set --</option>
                        @foreach($representatives as $person)
                            <option
                                {{ ($user->RepresentativeId == $person->Id) ? 'selected' : '' }}
                                value="{{$person->Id}}">
                                ({{ rand(0,1) ? 'R' : 'D' }}) {{$person->Name}}</option>
                        @endforeach
                    </select>

                    <label for="senator">Senator</label>
                    <select id="senator" name="SenatorId">
                        <option value=''>-- not set --</option>
                        @foreach($senators as $person)
                            <option
                                {{ ($user->SenatorId == $person->Id) ? 'selected' : '' }}
                                value="{{$person->Id}}">
                                ({{ rand(0,1) ? 'R' : 'D' }}) {{$person->Name}}</option>
                        @endforeach
                    </select>

                    <input type="submit" value="Save legislators">
                </form>
            </div>
        </div>
    </div>
@endsection
