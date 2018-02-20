<ul class="nav-list">
    <li class="nav-item {{ (Request::is('login') ? 'is-active' : '') }}">
        <a href="{{url('/login')}}">Home</a>
    </li>
    <li class="nav-item {{ (Request::is('about') ? 'is-active' : '') }}">
        <a href="{{url('/about')}}">About</a>
    </li>
    <li class="nav-item {{ (Request::is('support') ? 'is-active' : '') }}">
        <a href="{{url('/support')}}">Donate</a>
    </li>
</ul>