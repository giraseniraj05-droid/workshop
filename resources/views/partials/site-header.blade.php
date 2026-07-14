@php
    $page = $page ?? null;
@endphp

<header x-data="{ mobileOpen: false }" class="{{ $page === 'register' ? 'register-header' : 'login-header' }}">
    <div class="header-row">
        <div class="flex items-center gap-3">
            @if($page === 'admin')
                <button @click.stop="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 hover:text-slate-700 p-2 rounded-lg hover:bg-slate-100 transition" aria-label="Toggle sidebar" type="button">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            @endif
            <a href="{{ route('home') }}" class="brand">
                <x-application-logo class="h-9 w-9" />
                <span class="brand-name">{{ __('messages.app_name') }}</span>
            </a>
        </div>

        <!-- Desktop actions: hidden below md, shown at md+ -->
        <div class="header-actions hidden md:flex">
            <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}" class="lang-pill">
                <i class="fa-solid fa-language"></i>
                <span>{{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}</span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="header-link{{ $page === 'dashboard' ? ' is-active' : '' }}">{{ __('Dashboard') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="inline-block m-0 p-0">
                    @csrf
                    <button type="submit" class="header-link">
                        {{ __('Log Out') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="header-link{{ $page === 'login' ? ' is-active' : '' }}">{{ __('Sign In') }}</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="header-link{{ $page === 'register' ? ' is-active' : '' }}">{{ __('Register') }}</a>
                @endif
            @endauth
        </div>

        <!-- Hamburger: shown below md, hidden at md+ -->
        <button @click="mobileOpen = !mobileOpen" class="md:hidden inline-flex items-center justify-center rounded-lg p-2 text-slate-600 hover:bg-slate-100 focus:outline-none" aria-label="Toggle menu" type="button">
            <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile dropdown panel -->
    <div x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false" class="md:hidden flex flex-col gap-3 px-4 pb-4 mt-4 border-t border-slate-100 pt-4">
        <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}" class="lang-pill w-full justify-center">
            <i class="fa-solid fa-language"></i>
            <span>{{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}</span>
        </a>
        @auth
            <a href="{{ route('dashboard') }}" class="header-link{{ $page === 'dashboard' ? ' is-active' : '' }} w-full justify-center">{{ __('Dashboard') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="w-full m-0 p-0">
                @csrf
                <button type="submit" class="header-link w-full justify-center">
                    {{ __('Log Out') }}
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="header-link{{ $page === 'login' ? ' is-active' : '' }} w-full justify-center">{{ __('Sign In') }}</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="header-link{{ $page === 'register' ? ' is-active' : '' }} w-full justify-center">{{ __('Register') }}</a>
            @endif
        @endauth
    </div>
</header>