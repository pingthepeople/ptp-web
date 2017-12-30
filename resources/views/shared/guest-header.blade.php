<header class="guest-header" role="banner">
    <div class="content-wrapper guest-header__content">
        <a href="{{url('/')}}" class="guest-header__logo">
            <span class="guest-header__logo-graphic">
                <img src="{{asset('images/logo.png')}}" alt="">
            </span>
            <span class="guest-header__logo-words">Ping The People</span>
        </a>

        <nav class="guest-header__nav">
            <ul class="guest-header__nav-list">
                <li class="guest-header__nav-item {{ (Request::is('login') ? 'is-active' : '') }}">
                    <a href="{{url('/login')}}">Log in</a>
                </li>
                <li class="guest-header__nav-item {{ (Request::is('about') ? 'is-active' : '') }}">
                    <a href="{{url('/about')}}">About</a>
                </li>
                <li class="guest-header__nav-item {{ (Request::is('support') ? 'is-active' : '') }}">
                    <a href="{{url('/support')}}">Donate</a>
                </li>
            </ul>
        </nav>
    </div>
</header>
