<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Register') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet">

        @if (app()->getLocale() === 'ar')
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        @endif

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --register-primary: #1e40af;
                --register-secondary: #d97706;
                --register-accent: #4f46e5;
                --register-surface: rgba(255, 255, 255, 0.92);
                --register-border: rgba(255, 255, 255, 0.75);
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: #f8fafc;
                color: #0f172a;
                font-family: 'Figtree', sans-serif;
            }

            body[dir="rtl"] {
                font-family: 'Cairo', sans-serif;
            }

            .register-shell {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background:
                    radial-gradient(circle at top left, rgba(30, 64, 175, 0.18), transparent 32%),
                    radial-gradient(circle at top right, rgba(217, 119, 6, 0.16), transparent 28%),
                    linear-gradient(180deg, #f8fafc 0%, #eef4ff 100%);
            }



            .register-main {
                flex: 1;
                display: grid;
                place-items: center;
                padding: 36px 24px 48px;
            }

            .register-grid {
                width: min(1180px, 100%);
                display: grid;
                grid-template-columns: 1.05fr 0.95fr;
                gap: 28px;
                align-items: stretch;
            }

            .hero-panel,
            .form-panel {
                border-radius: 28px;
                overflow: hidden;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
                transition: transform 750ms cubic-bezier(0.16, 1, 0.3, 1),
                            box-shadow 750ms cubic-bezier(0.16, 1, 0.3, 1),
                            background 750ms cubic-bezier(0.16, 1, 0.3, 1),
                            border-color 750ms cubic-bezier(0.16, 1, 0.3, 1);
                will-change: transform, box-shadow, background;
                transform: scale3d(1, 1, 1) translate3d(0, 0, 0);
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
            }

            .hero-panel:hover,
            .form-panel:hover {
                transition-delay: 0ms !important;
                transform: scale3d(1.02, 1.02, 1) translate3d(0, -4px, 0);
                box-shadow: 0 32px 75px -12px rgba(15, 23, 42, 0.35);
            }

            .hero-panel {
                position: relative;
                padding: 56px;
                color: white;
                background: linear-gradient(135deg, #1d4ed8 0%, #ea580c 52%, #4338ca 100%);
                transition: background 750ms cubic-bezier(0.16, 1, 0.3, 1);
            }

            .hero-panel:hover {
                background: linear-gradient(135deg, #b45309 0%, #78350f 50%, #451a03 100%) !important;
            }

            .hero-panel::before,
            .hero-panel::after {
                content: '';
                position: absolute;
                border-radius: 999px;
                filter: blur(8px);
            }

            .hero-panel::before {
                inset: 18px auto auto -120px;
                width: 320px;
                height: 320px;
                background: rgba(255, 255, 255, 0.12);
            }

            .hero-panel::after {
                right: -140px;
                bottom: -130px;
                width: 280px;
                height: 280px;
                background: rgba(255, 255, 255, 0.08);
            }

            .hero-badge {
                position: relative;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 16px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.18);
                font-size: 0.8rem;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                backdrop-filter: blur(14px);
            }

            .hero-title {
                position: relative;
                margin: 22px 0 0;
                font-size: clamp(2.6rem, 5vw, 4.8rem);
                line-height: 0.95;
                font-weight: 900;
                letter-spacing: -0.05em;
                max-width: 11ch;
            }

            .hero-copy {
                position: relative;
                margin: 20px 0 0;
                max-width: 34rem;
                font-size: 1.05rem;
                line-height: 1.8;
                color: rgba(255, 255, 255, 0.92);
            }

            .feature-grid {
                position: relative;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 14px;
                margin-top: 34px;
            }

            .feature-card {
                border: 1px solid rgba(255, 255, 255, 0.16);
                background: rgba(255, 255, 255, 0.11);
                border-radius: 22px;
                padding: 16px;
                min-height: 110px;
                display: flex;
                align-items: flex-end;
                font-size: 0.92rem;
                line-height: 1.7;
                font-weight: 600;
                backdrop-filter: blur(10px);
                transition: transform 300ms cubic-bezier(0.16, 1, 0.3, 1),
                            background-color 300ms cubic-bezier(0.16, 1, 0.3, 1),
                            box-shadow 300ms cubic-bezier(0.16, 1, 0.3, 1),
                            border-color 300ms cubic-bezier(0.16, 1, 0.3, 1);
                will-change: transform;
            }

            .feature-card:hover {
                transform: translateY(-3px) scale(1.03);
                background: rgba(255, 255, 255, 0.22);
                border-color: rgba(255, 255, 255, 0.45);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            }

            .hero-actions {
                position: relative;
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
                margin-top: 32px;
            }

            .hero-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 48px;
                padding: 0 22px;
                border-radius: 14px;
                text-decoration: none;
                font-weight: 800;
                transition: transform 180ms ease, box-shadow 180ms ease;
            }

            .hero-button.primary {
                color: #1d4ed8;
                background: white;
                box-shadow: 0 16px 28px rgba(15, 23, 42, 0.14);
            }

            .hero-button.secondary {
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.22);
                background: rgba(255, 255, 255, 0.12);
            }

            .form-panel {
                display: flex;
                flex-direction: column;
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(16px);
                border: 1px solid var(--register-border);
                transition: background 750ms cubic-bezier(0.16, 1, 0.3, 1);
            }

            .form-panel:hover {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%) !important;
            }

            .form-header,
            .form-kicker,
            .form-title,
            .form-subtitle,
            .field-label,
            .field-help,
            .checkbox-text,
            .footer-text,
            .footer-link,
            .control {
                transition: color 750ms cubic-bezier(0.16, 1, 0.3, 1),
                            background-color 750ms cubic-bezier(0.16, 1, 0.3, 1),
                            border-color 750ms cubic-bezier(0.16, 1, 0.3, 1);
            }

            .form-panel:hover .form-header {
                background: transparent !important;
                border-bottom-color: rgba(255, 255, 255, 0.15) !important;
            }
            .form-panel:hover .form-kicker {
                background: rgba(255, 255, 255, 0.18) !important;
                color: #ffffff !important;
            }
            .form-panel:hover .form-title {
                color: #ffffff !important;
            }
            .form-panel:hover .form-subtitle {
                color: rgba(255, 255, 255, 0.82) !important;
            }
            .form-panel:hover .field-label {
                color: #ffffff !important;
            }
            .form-panel:hover .field-help {
                color: #93c5fd !important;
            }
            .form-panel:hover .checkbox-text {
                color: rgba(255, 255, 255, 0.9) !important;
            }
            .form-panel:hover .footer-text {
                color: rgba(255, 255, 255, 0.8) !important;
            }
            .form-panel:hover .footer-link {
                color: #60a5fa !important;
            }
            .form-panel:hover .control {
                background: rgba(255, 255, 255, 0.12) !important;
                border-color: rgba(255, 255, 255, 0.25) !important;
                color: #ffffff !important;
            }
            .form-panel:hover .control::placeholder {
                color: rgba(255, 255, 255, 0.5) !important;
            }

            .form-header {
                padding: 34px 34px 24px;
                border-bottom: 1px solid rgba(226, 232, 240, 0.9);
                background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 52%, #fffbeb 100%);
            }

            .form-kicker {
                display: inline-flex;
                padding: 8px 12px;
                border-radius: 999px;
                background: rgba(30, 64, 175, 0.08);
                color: var(--register-primary);
                font-size: 0.76rem;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
            }

            .form-title {
                margin: 18px 0 0;
                font-size: clamp(2rem, 3.8vw, 3rem);
                line-height: 1;
                font-weight: 900;
                letter-spacing: -0.04em;
                color: #172554;
            }

            .form-subtitle {
                margin: 14px 0 0;
                color: #475569;
                font-size: 1rem;
                line-height: 1.8;
            }

            .form-body {
                padding: 30px 34px 34px;
            }

            .field {
                margin-bottom: 18px;
            }

            .field-label {
                display: block;
                margin-bottom: 10px;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.22em;
                text-transform: uppercase;
                color: #64748b;
            }

            .control {
                width: 100%;
                box-sizing: border-box;
                border: 1px solid #cbd5e1;
                border-radius: 18px;
                padding: 14px 16px;
                font-size: 0.98rem;
                color: #0f172a;
                background: white;
                outline: none;
                transition: border-color 180ms ease, box-shadow 180ms ease, transform 180ms ease;
            }

            .control:focus {
                border-color: rgba(30, 64, 175, 0.55);
                box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.12);
            }

            .password-wrap {
                position: relative;
            }

            .password-wrap .control {
                padding-right: 56px;
            }

            .password-toggle {
                position: absolute;
                inset-inline-end: 0;
                top: 0;
                bottom: 0;
                width: 52px;
                display: grid;
                place-items: center;
                border: 0;
                background: transparent;
                color: #1e3a8a;
                cursor: pointer;
            }

            .remember-row {
                display: flex;
                align-items: center;
                gap: 12px;
                margin: 8px 0 18px;
                color: #475569;
                font-size: 0.95rem;
            }

            .remember-row input {
                width: 18px;
                height: 18px;
                accent-color: var(--register-primary);
            }

            .submit-button {
                width: 100%;
                min-height: 48px;
                border: 0;
                border-radius: 16px;
                background: linear-gradient(135deg, var(--register-primary), var(--register-accent));
                color: white;
                font-size: 0.98rem;
                font-weight: 800;
                cursor: pointer;
                box-shadow: 0 16px 28px rgba(30, 64, 175, 0.18);
                position: relative;
                overflow: hidden;
                transition: transform 250ms cubic-bezier(0.16, 1, 0.3, 1), box-shadow 250ms cubic-bezier(0.16, 1, 0.3, 1);
            }

            .submit-button::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.28) 50%, transparent 100%);
                transition: transform 650ms cubic-bezier(0.16, 1, 0.3, 1);
                pointer-events: none;
            }

            .submit-button:hover {
                transform: translateY(-2px) scale(1.04);
                box-shadow: 0 20px 32px rgba(30, 64, 175, 0.3);
            }

            .submit-button:hover::after {
                transform: translateX(200%);
            }

            .submit-button:active {
                transform: translateY(0) scale(0.97);
            }

            .footer-line {
                margin-top: 20px;
                padding-top: 16px;
                border-top: 1px solid rgba(226, 232, 240, 0.9);
                text-align: center;
                color: #64748b;
                font-size: 0.94rem;
            }

            .footer-line a {
                font-weight: 800;
                color: var(--register-primary);
            }

            .terms-box {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                margin: 8px 0 16px;
                border: 1px solid rgba(226, 232, 240, 0.95);
                border-radius: 18px;
                padding: 14px 16px;
                background: rgba(248, 250, 252, 0.9);
                color: #475569;
                font-size: 0.93rem;
                line-height: 1.7;
            }

            .terms-box input {
                margin-top: 4px;
                width: 18px;
                height: 18px;
                accent-color: var(--register-primary);
            }

            .terms-box a {
                font-weight: 800;
                color: var(--register-primary);
            }

            .helper-text {
                margin-top: 8px;
                color: #64748b;
                font-size: 0.88rem;
                line-height: 1.6;
            }

            .errors {
                margin-top: 8px;
                color: #dc2626;
                font-size: 0.88rem;
                line-height: 1.5;
            }



            @media (max-width: 1024px) {
                .register-grid {
                    grid-template-columns: 1fr;
                }

                .hero-panel {
                    min-height: auto;
                }
            }

            @media (max-width: 768px) {


                .register-main {
                    padding: 18px 14px 28px;
                }

                .hero-panel,
                .form-panel {
                    border-radius: 24px;
                }

                .hero-panel,
                .form-header,
                .form-body {
                    padding-left: 22px;
                    padding-right: 22px;
                }

                .feature-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
    <body>
        <div class="register-shell">
            @include('partials.site-header', ['page' => 'register'])

            <main class="register-main">
                <div class="register-grid animate-page-entrance">
                    <section class="hero-panel running-border-active" aria-label="{{ __('messages.hero_title') }}">
                        <span class="hero-badge">
                            <i class="fa-solid fa-bolt"></i>
                            {{ __('messages.hero_badge') }}
                        </span>

                        <h1 class="hero-title">{{ __('Create your account in minutes.') }}</h1>
                        <p class="hero-copy">
                            {{ __('Join a cleaner, faster way to book trusted home services with a setup that feels as polished as the homepage.') }}
                        </p>

                        <div class="feature-grid">
                            <div class="feature-card">{{ __('Quick booking from any device') }}</div>
                            <div class="feature-card">{{ __('Trusted professionals and clear pricing') }}</div>
                            <div class="feature-card">{{ __('A smoother start than the old form layout') }}</div>
                        </div>

                        <div class="hero-actions">
                            <a href="{{ route('home') }}#services-list" class="hero-button primary">
                                {{ __('messages.browse_services_btn') }}
                            </a>
                            <a href="{{ route('home') }}" class="hero-button secondary">
                                {{ __('messages.app_name') }}
                            </a>
                        </div>
                    </section>

                    <section class="form-panel running-border-active" aria-label="{{ __('Register') }}">
                        <div class="form-header">
                            <span class="form-kicker">{{ __('messages.register') }}</span>
                            <h2 class="form-title">{{ __('Create Account') }}</h2>
                            <p class="form-subtitle">{{ __('Book trusted home service professionals in minutes.') }}</p>
                        </div>

                        <div class="form-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="field">
                                    <label for="name" class="field-label">{{ __('Full Name') }}</label>
                                    <x-text-input id="name" class="control" type="text" name="name" :value="old('name')" placeholder="{{ __('John Doe') }}" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="errors" />
                                </div>

                                <div class="field">
                                    <label for="email" class="field-label">{{ __('Email Address') }}</label>
                                    <x-text-input id="email" class="control" type="email" name="email" :value="old('email')" placeholder="{{ __('name@company.com') }}" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="errors" />
                                </div>

                                <div class="field">
                                    <label for="password" class="field-label">{{ __('Password') }}</label>
                                    <div class="password-wrap">
                                        <x-password-toggle id="password" name="password" autocomplete="new-password" required class="control" />
                                    </div>
                                    <p class="helper-text">{{ __('Must be at least 8 characters with a mix of letters and symbols.') }}</p>
                                    <x-input-error :messages="$errors->get('password')" class="errors" />
                                </div>

                                <div class="field">
                                    <label for="password_confirmation" class="field-label">{{ __('Confirm Password') }}</label>
                                    <div class="password-wrap">
                                        <x-password-toggle id="password_confirmation" name="password_confirmation" autocomplete="new-password" required class="control" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="errors" />
                                </div>

                                <label class="terms-box">
                                    <input id="terms" name="terms" type="checkbox" required {{ old('terms') ? 'checked' : '' }}>
                                    <span>
                                        {{ __('I agree to the') }}
                                        <a href="{{ route('terms.service') }}">{{ __('Terms of Service') }}</a>
                                        {{ __('and') }}
                                        <a href="{{ route('privacy.policy') }}">{{ __('Privacy Policy') }}</a>.
                                    </span>
                                </label>

                                <x-input-error :messages="$errors->get('terms')" class="errors" />

                                <button type="submit" class="submit-button">{{ __('Create Account') }}</button>

                                <div class="footer-line">
                                    <span>{{ __('Already have an account?') }}</span>
                                    <a href="{{ route('login') }}">{{ __('Sign In') }}</a>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </main>

            @include('partials.site-footer')
        </div>
    </body>
</html>