@extends('layouts.guest')

@section('title', 'Donate | Ping the People')

@section('content')

@if(Auth::check())
    @include('shared.header')
@else
    @include('shared.guest-header')
@endif

<div class="content-wrapper" >
    <div class="primo-content">

        <h1 class="section-title">Donate</h1>

        <p><em>Ping the People will always be free to use.</em> We believe that every 
        person and organization working for positive change in Indiana should have 
        access to timely information about legislation that matters to them, 
        regardless of their financial circumstances.</p> 
        
        <p>Unfortunately, <em>Ping the People is not free to run.</em> Web, 
        database, and messaging services cost about $75 a month, which we pay 
        even even when the Assembly is not in session. If you value Ping the 
        People, and are able to do so, please consider making a donation via the 
        PayPal <em>Donate</em> button below.</p>
        
        <p>Thank you for your support, and for working to make Indiana better.</p>

        <p><a href="https://twitter.com/ohnoitsaustin">Austin</a> 
        and <a href="https://twitter.com/johnhoerr">John</a>
        
        <div class="u-flex">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="P459Y9V79JUP8">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
    </div>
</div>

@endsection
