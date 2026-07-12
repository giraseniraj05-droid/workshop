<footer class="mt-auto border-t border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 text-sm text-slate-500 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
        <div class="flex flex-col gap-1">
            <span class="font-semibold tracking-[0.16em] text-primary-darker/70">
                {{ __('messages.app_name') }}
            </span>
            <div class="flex flex-col gap-0.5 text-slate-500 text-xs my-1">
                <span><i class="fa-solid fa-user text-slate-400 mr-1.5"></i> {{ __('messages.footer_contact_name') }}</span>
                <span><i class="fa-solid fa-phone text-slate-400 mr-1.5"></i> {{ __('messages.footer_contact_phone') }}</span>
                <span><i class="fa-solid fa-envelope text-slate-400 mr-1.5"></i> {{ __('messages.footer_contact_email') }}</span>
            </div>
            <span class="text-slate-500">&copy; 2026 {{ __('messages.app_name') }}. All rights reserved.</span>
        </div>

        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 lg:justify-end">
            <a href="{{ route('privacy.policy') }}" class="text-slate-500 transition hover:text-primary">{{ __('Privacy Policy') }}</a>
            <a href="{{ route('terms.service') }}" class="text-slate-500 transition hover:text-primary">{{ __('Terms of Service') }}</a>
            <a href="{{ route('cookie.settings') }}" class="text-slate-500 transition hover:text-primary">{{ __('Cookie Settings') }}</a>
        </div>
    </div>
</footer>
