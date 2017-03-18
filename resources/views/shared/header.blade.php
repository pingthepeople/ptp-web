<header class="header">
    <div class="container">
        <div class="row">
            <div class="twelve columns header__inner">
                <div class="header__primary">
                    <nav class="main-nav">
                        <div class="logo">
                            <a href="{{url('/')}}">Ping the People</a>
                        </div>
                        <ul>
                            <li {{ (Request::is('/') ? 'class=is-active' : '') }}>
                                <a href="{{url('/')}}">My bills</a>
                            </li>
                            <li {{ (Request::is('all-bills') ? 'class=is-active' : '') }}>
                                <a href="{{url('/all-bills')}}">All bills</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header__secondary">
                    @if (Auth::check())
                        <div class="user">
                            Hello, <a href="{{url('/account')}}" {{ (Request::is('account') ? 'class=is-active' : '') }}>{{ $user->Name }}</a>
                        </div>

                        <a href="{{ url('/logout') }}">Logout</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>