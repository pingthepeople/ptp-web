@extends('layouts.main')

@section('title', 'INaction')

@section('content')
    <div class="bill-list bill-list--all-bills">
        <h1>All bills</h1>
        <a href="{{url('/')}}">My bills</a>

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