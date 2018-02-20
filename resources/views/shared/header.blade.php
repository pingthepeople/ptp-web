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
                    @include("shared.nav-list")
                </nav>
            </div>
            <button :class="showNav?'is-active':''" class="mobile-nav-trigger" @click="showNav=!showNav">Menu</button>  
        </div>
    </div>
    <transition name="collapse">
        <nav v-show="showNav" v-cloak class="mobile-nav">
            @include("shared.nav-list")
        </nav>
    </transition>
</header>
