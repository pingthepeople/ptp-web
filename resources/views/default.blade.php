@extends('layouts.main')

@section('title', 'INaction')

@section('content')
    <div class="bill-list bill-list--tracked-by-user">
        <h1>Your bills</h1>
        <a href="{{url('/all-bills')}}">All bills</a>

        @if($user->bills->count())
            @foreach($user->bills as $bill)
                @include('blocks.bill', ['bill' => $bill])
            @endforeach
        @else
            <div class="empty-state">
                <p>You are not tracking any bills. <a href="{{url('/all-bills')}}">View all bills</a> to start tracking something.</p>
            </div>
        @endif
    </div>
@endsection