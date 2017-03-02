<header class="header">
    <div class="row">
        <div class="twelve columns">
            <div class="u-pull-left">
                <div class="logo">
                    INaction
                </div>
            </div>
            <div class="u-pull-right">
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
</header>