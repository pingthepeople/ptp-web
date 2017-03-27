@extends('layouts.main')

@section('title', 'Ping the People')

@section('content')
    <h1>Welcome to <strong>Ping the People</strong>!</h1>
    <div class="welcome">
        <p><strong>Ping the People</strong> makes it easy to discover, track, and get instant updates on Indiana legislation that is important to you. Here's how to get started:</p>
        <ol>
            <li>Search <a href="/all-bills"><em>All Legislation</em></a> below by number, committee, subject, keyword, etc. Click the <strong>Watch</strong> button to add legislation to your watchlist. You can add or remove items whenever you'd like.</li>
            <li>Check <watchlist-link><em>My Watchlist</em></watchlist-link> for the latest legislative updates and scheduled events. You can also choose to receive email and/or text message updates for each item.</li>
            <li>Confirm your email and mobile <a href="/account">contact preferences</a> for updates and daily roundups. </li>
        </ol>
    </div>
    <hr>

    <div class="bill-list bill-list--all-bills">
        <all-bills></all-bills>
    </div>
@endsection