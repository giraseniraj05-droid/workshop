
@props(['page' => null])

@php
    $actionLabel = __('Sign In');
    $actionHref = route('login');
    $actionVariant = $page === 'login' ? 'link' : 'button';
@endphp

<header class="border-b border-slate-200 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/80">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <x-application-logo class="h-10 w-10 text-primary" />
            <span class="text-base font-extrabold tracking-[0.18em] text-primary-darker sm:text-lg">
                {{ __('messages.app_name') }}
            </span>
        </a>

        <div class="flex items-center gap-3 sm:gap-4">
            <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-primary/30 hover:text-primary-dark">
                <i class="fa-solid fa-language"></i>
                <span>{{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}</span>
            </a>

            @if ($actionVariant === 'button')
                <a href="{{ $actionHref }}" class="inline-flex items-center rounded-full bg-gradient-to-r from-primary to-secondary px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-primary/20 hover:from-primary-dark hover:to-secondary-dark">
                    {{ $actionLabel }}
                </a>
            @else
                <a href="{{ $actionHref }}" aria-current="page" class="inline-flex items-center rounded-full border-b-2 border-primary px-1 py-2 text-sm font-bold text-primary-dark">
                    {{ $actionLabel }}
                </a>
            @endif
        </div>
    </div>
</header>
