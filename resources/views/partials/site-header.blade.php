@php
    $page = $page ?? null;
@endphp

<header class="{{ $page === 'register' ? 'register-header' : 'login-header' }}">
    <a href="{{ route('home') }}" class="brand">
        <x-application-logo class="h-9 w-9" />
        <span class="brand-name">{{ __('messages.app_name') }}</span>
    </a>

    <div class="header-actions">
        <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}" class="lang-pill">
            <i class="fa-solid fa-language"></i>
            <span>{{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}</span>
        </a>
        <a href="{{ route('login') }}" class="header-link{{ $page === 'login' ? ' is-active' : '' }}">{{ __('Sign In') }}</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="header-link{{ $page === 'register' ? ' is-active' : '' }}">{{ __('Register') }}</a>
        @endif
    </div>
</header>