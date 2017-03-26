@extends('layouts.guest')

@section('title', 'Ping the People')

@section('content')
    <div class="hero">
        <div class="content">

            <p class="hero__tagline">
                <span class="hero__tagline-part">Updates about Indiana legislation in real time.</span>
                <span class="hero__tagline-part">At-a-glance information about upcoming legislative activity.</span>
                <span class="hero__tagline-part">A more perfect Union.</span>
            </p>

            <h1 class="hero__welcome">Welcome to <strong>Ping the People</strong></h1>

            <p><a class="button button--large button--fb" href="http://ping.dev/login-via-facebook">Log in with Facebook</a>

                <a class="button button--large button--google" href="http://ping.dev/login-via-google">Log in with Google</a></p>
        </div>
    </div>
    <div class="home-section">
        <div class="content intro">
            <div class="intro__body">
                <h2>Keep tabs on Indiana state legislation</h2>
                <p>There are <strong>1,417</strong> pieces of legislation in the 2017 session of the Indiana General Assembly.</p>
                <p>It takes time to dig through legislation, track votes, and figure out what's happening next. That time could be better spent on outreach, organizing, and engagement.</p>
                <p>Ping the People will do the digging for you. You can easily discover, watch, and receive instant updates on the legislation that is important to you. We'll keep an eye on everything, and you can focus on getting things done.</p>

            </div>

            <aside class="intro__aside right">
                <h3>Search for topics important to you</h3>
                <div>
                    <img src="{{asset('images/homepage/discover.png')}}" alt="A screenshot of the search UI; the results of a search for 'kindergarten' shows bill HB 1004, Prekindergarten Education, along with details about the bill subject, description, committee, and an option to watch the bill">
                </div>
            </aside>

            <aside class="intro__aside">
                <h3>Track the status of  legislation</h3>
                <div><img src="{{asset('images/homepage/track.png')}}" alt="A screenshot of the Watchlist UI; the prekindergarten bill from the previous screenshot is displayed, along with its most recent and upcoming actions, and options to receive alerts via email and SMS"></div>
            </aside>

            <aside class="intro__aside right">
                <h3>Get instant alerts on legislative action</h3>
                <div>
                    <img width="225px" src="{{asset('images/homepage/sms.jpg')}}" alt="A screenshot of an SMS alert regarding the prekindergarten bill from the previous screenshot">
                    <img width="400px" src="{{asset('images/homepage/email.jpg')}}" alt="A screenshot of an email alert regarding the prekindergarten bill from the previous screenshot">
                </div>
            </aside>
        </div>
    </div>
    <div class="home-section">
        <div class="content">
            <p>Ping the People is a labor of love and a work in progress. If you have questions, comments, issues, or bug reports, please do not hesitate to <a href="mailto:help@pingthepeople.org">contact us</a>.</p>
        </div>
    </div>

@endsection