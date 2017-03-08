@extends('layouts.main')

@section('title', 'INaction')

@section('content')
    <div class="bill-list bill-list--all-bills">
        <h1>Get started</h1>
        <p>You are net yet tracking any bills this session.</p>

        <div class="bill-list bill-list--all-bills">
            <all-bills></all-bills>
        </div>
    </div>
@endsection