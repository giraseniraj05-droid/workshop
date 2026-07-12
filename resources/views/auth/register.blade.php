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

            .register-header {
                position: sticky;
                top: 0;
                z-index: 10;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                padding: 20px 28px;
                background: rgba(255, 255, 255, 0.82);
                backdrop-filter: blur(18px);
                border-bottom: 1px solid rgba(148, 163, 184, 0.18);
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 14px;
                text-decoration: none;
                color: inherit;
            }

            .brand-mark {
                width: 44px;
                height: 44px;
                display: grid;
                place-items: center;
                border-radius: 14px;
                background: linear-gradient(135deg, var(--register-primary), var(--register-secondary));
                color: white;
                font-weight: 800;
                box-shadow: 0 12px 28px rgba(30, 64, 175, 0.18);
            }

            .brand-name {
                font-size: 1rem;
                font-weight: 900;
                letter-spacing: 0.16em;
                text-transform: uppercase;
                color: #172554;
            }

            .header-actions {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .lang-pill,
            .header-link {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border-radius: 999px;
                text-decoration: none;
                font-weight: 700;
                transition: transform 180ms ease, box-shadow 180ms ease, background 180ms ease;
            }

            .lang-pill {
                padding: 10px 16px;
                border: 1px solid rgba(148, 163, 184, 0.35);
                color: #475569;
                background: rgba(255, 255, 255, 0.75);
            }

            .header-link {
                padding: 10px 18px;
                color: #0f172a;
                background: white;
                box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
            }

            .header-link.is-active {
                color: white;
                background: linear-gradient(135deg, var(--register-primary), var(--register-secondary));
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
                border-radius: 30px;
                overflow: hidden;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            }

            .hero-panel {
                position: relative;
                padding: 56px;
                color: white;
                background: linear-gradient(135deg, #1d4ed8 0%, #f97316 52%, #4338ca 100%);
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
                background: rgba(255, 255, 255, 0.88);
                backdrop-filter: blur(16px);
                border: 1px solid var(--register-border);
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

            .page-footer {
                margin-top: auto;
                border-top: 1px solid #1e293b;
                background: #0f172a;
                color: #94a3b8;
                padding: 48px 24px;
            }

            .page-footer-inner {
                width: min(1280px, 100%);
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 18px;
                align-items: center;
                justify-content: space-between;
                text-align: center;
            }

            .page-footer-brand {
                color: white;
                font-size: 1.25rem;
                font-weight: 900;
                letter-spacing: 0.18em;
            }

            .page-footer-copy {
                margin: 0;
                font-size: 0.95rem;
                line-height: 1.7;
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
                .register-header {
                    padding: 16px 18px;
                }

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
                <div class="register-grid">
                    <section class="hero-panel" aria-label="{{ __('messages.hero_title') }}">
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

                    <section class="form-panel" aria-label="{{ __('Register') }}">
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