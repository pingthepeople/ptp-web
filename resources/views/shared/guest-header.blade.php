<header class="guest-header" role="banner">
    <div class="content-wrapper guest-header__content">
        <a href="{{url('/')}}" class="guest-header__logo">
            <span class="guest-header__logo-graphic">
                <img src="{{asset('images/logo.png')}}" alt="">
            </span>
            <span class="guest-header__logo-words">Ping The People</span>
        </a>

        <nav class="guest-header__nav">
            @include("shared.guest-nav-list")
        </nav>
        <button :class="showNav?'is-active':''" class="mobile-nav-trigger" @click="showNav=!showNav">Menu</button>  
    </div>
    <transition name="collapse">
        <nav v-show="showNav" v-cloak class="mobile-nav">
            @include("shared.guest-nav-list")
        </nav>
    </transition>
</header>
