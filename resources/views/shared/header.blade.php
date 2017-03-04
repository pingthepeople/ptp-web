<header class="header">
    <div class="container">
        <div class="row">
            <div class="twelve columns header__inner">
                <div class="header__primary">
                    <nav class="main-nav">
                        <div class="logo">
                            <a href="{{url('/')}}">INaction</a>
                        </div>
                        <ul>
                            <li>
                                <a href="{{url('/')}}">My bills</a>
                            </li>
                            <li>
                                <a href="{{url('/all-bills')}}">All bills</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header__secondary">
                    @if (Auth::check())
                        @if(Auth::check())
                            <div class="user">
                                Hello, {{ $user->Name }}
                            </div>
                        @endif
                        <a href="{{ url('/logout') }}">Logout</a>
                    @else
                        <a href="{{ url('/login-via-facebook') }}">Login with Facebook</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>