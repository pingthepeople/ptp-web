@extends('layouts.main')

@section('title', 'All legislation | Ping the People')

@section('content')
    @if($showWelcome)
        <h1>Welcome to <strong>Ping the People</strong>!</h1>
        <div class="welcome">
            <p><strong>Ping the People</strong> makes it easy to discover, track, and get instant updates on Indiana legislation that matters to you. Here's how to get started:</p>
            <ol>
                <li>Search legislation by bill number, committee, subject, or keyword.</li>
                <li>Toggle tracking (<img class="welcome__tracking-icon" src="images/toggle.svg" alt="use the track legislation checkbox">) to add legislation to your watchlist.</li>
                <li>Check <watchlist-link><strong>My watch list</strong></watchlist-link> for the latest legislative updates and scheduled events. You can also choose to receive email or text message updates for each item.</li>
                <li>Confirm your email and mobile <a href="/account">contact preferences</a> for instant updates and daily roundups.</li>
            </ol>
        </div>
        <hr>
    @endif

    <div class="bill-list bill-list--all-bills">
        <all-bills></all-bills>
    </div>
@endsection
