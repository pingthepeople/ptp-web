@extends('layouts.guest')

@section('title', 'Support | Ping the People')

@section('content')

@if(Auth::check())
    @include('shared.header')
@else
    @include('shared.guest-header')
@endif

<div class="content-wrapper" >
    <div class="primo-content">

        <h1 class="section-title">Support</h1>

        <p>Ping the People is free. However, if you like Ping the People, would like to see it do more, and are able to do so, we encourage you to support Ping the People via PayPal.</p>

        <div class="u-flex">
            <div class="u-flex-1">
                <p>Your contribution supports:</p>

                <ul>
                    <li>Infrastructure overhead (web hosting, etc)</li>
                    <li>Time spent building new features</li>
                    <li>Our coffee addiction</li>
                </ul>
            </div>
            <div class="u-right m-top-sm">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="P459Y9V79JUP8">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
