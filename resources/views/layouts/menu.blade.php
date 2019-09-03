<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}">
            <img src="{{asset('images/weblog_logo.png')}}" width="112" height="28">
        </a>

        <a role="button" class="navbar-burger burger" v-on:click="showNav = !showNav" v-bind:class="{ 'is-active' : showNav }" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu" v-bind:class="{ 'is-active' : showNav }">
        @auth
        <!-- Admin links -->
        <div class="navbar-start">
            <a class="navbar-item" href="{{ route('admin.messages.index') }}">{{ __('Weblog') }}</a>
            <a class="navbar-item" href="{{ route('admin.categories.index') }}">{{ __('Categories') }}</a>
        </div>
        @endauth

        <!-- Authentication Links -->
        @guest
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="button is-primary">
                        <strong>{{ __('Register') }}</strong>
                    </a>
                    <a href="{{ route('login') }}" class="button is-light">
                        {{ __('Login') }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="navbar-dropdown">

                    <!-- <a href="{{ route('admin.messages.index') }}" class="navbar-item">{{ __('Messages') }}</a>
        
                    <a href="{{ route('categories.index') }}" class="navbar-item">{{ __('Categories') }}</a> -->
                    
                    <a class="navbar-item">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </div>
            </div>
        </div>
        @endguest
    
    </div>
</nav>