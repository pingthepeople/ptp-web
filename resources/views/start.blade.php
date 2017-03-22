@extends('layouts.main')

@section('title', 'Ping the People')

@section('content')
    <div class="bill-list bill-list--all-bills">

        <h1>Welcome to Ping the People!</h1>
        <p>
            <em>Ping the People</em> makes it easy to discover and track Indiana legislation that is important to you. Here's how to get started:
            <ol>
                <li><a href="/all-bills">Search the bills</a> by name, subject, keyword, etc and click the <strong>Watch</strong> button to add to your list.<li>
                <li>Check your <a href="/">watch list</a> for the latest legislative updates and scheduled events, and choose what kind of alerts to receive.</li>
                <li>Set your <a href="/account">contact preferences</a> for alerts and daily activity digests.</li>
            </ol>
        </p>

        <div class="bill-list bill-list--all-bills">
            <all-bills></all-bills>
        </div>
    </div>
@endsection