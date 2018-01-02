<header class="header" role="banner">
    <div class="content-wrapper">
        <div class="header__inner">
            <div class="header__primary">
                <a href="{{url('/')}}" class="header__logo">
                    <span class="header__logo-graphic">
                        <img src="{{asset('images/logo.png')}}" alt="">
                    </span>
                    <span class="header__logo-words">Ping The People</span>
                </a>
            </div>
            <div class="header__secondary">
                <nav class="main-nav">
                    <ul>
                        <li {{ (Request::is('/') ? 'class=is-active' : '') }}>
                            <a href="{{url('/')}}">My watch list</a>
                        </li>
                        <li {{ (Request::is('bills/*') || Request::is('bills') ? 'class=is-active' : '') }}>
                            <a href="{{url('/bills')}}">All legislation</a>
                        </li>
                        <li {{ (Request::is('account') ? 'class=is-active' : '') }}>
                            <a href="{{url('/account')}}">Settings</a>
                        </li>
                        <li {{ (Request::is('support') ? 'class=is-active' : '') }}>
                            <a href="{{url('/support')}}">Donate</a>
                        </li>
                        <li {{ (Request::is('logout') ? 'class=is-active' : '') }}>
                            <a href="{{ url('/logout') }}">Logout</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
