@extends('layouts.main')

@section('title', 'Ping the People')

@section('content')
    <div class="bill-list bill-list--all-bills">

        <h1>Welcome to <em>Ping the People</em>!</h1>
        <p>
            <em>Ping the People</em> makes it easy to discover, track, and get instant updates on Indiana legislation that is important to you. Here's how to get started:
            <ol>
                <li><strong>1.</strong> Search <a href="/all-bills"><em>All Bills</em></a> below by name, subject, keyword, etc. Click the <strong>Watch</strong> button to add a bill to your watchlist. You can add or remove bills whenever you'd like.<li>
                <li><strong>2.</strong> Check <a href="/"><em>My Watchlist</em></a> for the latest legislative updates and scheduled events. You can also choose to receive email and/or text message updates for each bill.</li>
                <li><strong>3.</strong> Confirm your email and mobile <a href="/account">contact preferences</a> for updates and daily roundups. </li>
            </ol>
        </p>

        <hr>

        <div class="bill-list bill-list--all-bills">
            <all-bills></all-bills>
        </div>
    </div>
@endsection