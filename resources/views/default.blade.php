@extends('layouts.main')

@section('title', 'INaction')

@section('content')
    <div class="bill-list bill-list--tracked-by-user">
        <h1>Your bills</h1>

        <my-bills></my-bills>
    </div>
@endsection