@extends('layouts.main')

@section('title', 'Ping the People')

@section('content')
    <div class="bill-list bill-list--all-bills">
        <h1>Get started</h1>
        <p>You are net yet watching any bills this session. Search for bills and click the "Watch" button to get started. Be sure to review your <a href="/account">contact preferences</a> if you'd like to receive alerts about the bills you're watching.</p>

        <div class="bill-list bill-list--all-bills">
            <all-bills></all-bills>
        </div>
    </div>
@endsection