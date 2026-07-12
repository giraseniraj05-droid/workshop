<footer class="page-footer">
    <div class="page-footer-inner">
        <span class="page-footer-brand">{{ __('messages.app_name') }}</span>
        <div class="flex flex-col gap-0.5 text-slate-400 text-xs my-2 text-center" style="display: flex; flex-direction: column; gap: 4px; margin-top: 8px; margin-bottom: 8px; align-items: center;">
            <span><i class="fa-solid fa-user text-slate-500 mr-1.5"></i> {{ __('messages.footer_contact_name') }}</span>
            <span><i class="fa-solid fa-phone text-slate-500 mr-1.5"></i> {{ __('messages.footer_contact_phone') }}</span>
            <span><i class="fa-solid fa-envelope text-slate-500 mr-1.5"></i> {{ __('messages.footer_contact_email') }}</span>
        </div>
        <p class="page-footer-copy">
            &copy; {{ date('Y') }} {{ __('messages.app_name') }}. All rights reserved. Urban Company-inspired Marketplace.
        </p>
    </div>
</footer>