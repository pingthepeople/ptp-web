@extends('layouts.main')

@section('title', 'INaction')

@section('content')
    <div class="bill-list bill-list--all-bills">
        <h1>Get started</h1>
        <p>You are net yet tracking any bills this session.</p>

        @if($bills->count())
            @foreach($bills as $bill)
                @include('blocks.bill', ['bill' => $bill])
            @endforeach
        @else
            <div class="empty-state">
                <p>There are no bills to track.</p>
            </div>
        @endif
    </div>
@endsection