<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - {{ __('Sign In') }}</title>

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
                --login-primary: #1e40af;
                --login-secondary: #d97706;
                --login-accent: #4f46e5;
                --login-surface: rgba(255, 255, 255, 0.92);
                --login-border: rgba(255, 255, 255, 0.75);
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

            .login-shell {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background:
                    radial-gradient(circle at top left, rgba(30, 64, 175, 0.18), transparent 32%),
                    radial-gradient(circle at top right, rgba(217, 119, 6, 0.16), transparent 28%),
                    linear-gradient(180deg, #f8fafc 0%, #eef4ff 100%);
            }



            .login-main {
                flex: 1;
                display: grid;
                place-items: center;
                padding: 36px 24px 48px;
            }

            .login-grid {
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
                transition: transform 450ms cubic-bezier(0.16, 1, 0.3, 1),
                            box-shadow 450ms cubic-bezier(0.16, 1, 0.3, 1),
                            border-color 450ms cubic-bezier(0.16, 1, 0.3, 1);
                will-change: transform, box-shadow;
                transform: translateZ(0);
                backface-visibility: hidden;
            }

            .hero-panel:hover,
            .form-panel:hover {
                transition-delay: 0ms !important;
                transform: scale3d(1.015, 1.015, 1) translate3d(0, -2px, 0);
                box-shadow: 0 32px 70px -12px rgba(15, 23, 42, 0.22), 0 0 0 1px rgba(59, 130, 246, 0.25);
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
                background: rgba(255, 255, 255, 0.88);
                backdrop-filter: blur(16px);
                border: 1px solid var(--login-border);
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
                color: var(--login-primary);
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

            .session-status {
                margin-bottom: 18px;
            }

            .field {
                margin-bottom: 18px;
            }

            .field-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                margin-bottom: 10px;
            }

            .field-label {
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.22em;
                text-transform: uppercase;
                color: #64748b;
            }

            .field-help {
                font-size: 0.75rem;
                font-weight: 800;
                text-decoration: underline;
                color: var(--login-secondary);
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
                border-color: rgba(30, 64, 175, 0.65);
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.18), 0 4px 12px -2px rgba(59, 130, 246, 0.1);
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
                accent-color: var(--login-primary);
            }

            .submit-button {
                width: 100%;
                padding: 15px 18px;
                border: none;
                border-radius: 16px;
                background: linear-gradient(135deg, var(--login-primary), var(--login-accent));
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
                color: var(--login-primary);
            }

            .errors {
                margin-top: 8px;
                color: #dc2626;
                font-size: 0.88rem;
                line-height: 1.5;
            }



            @media (max-width: 1024px) {
                .login-grid {
                    grid-template-columns: 1fr;
                }

                .hero-panel {
                    min-height: auto;
                }
            }

            @media (max-width: 768px) {


                .login-main {
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
        <div class="login-shell">
            @include('partials.site-header', ['page' => 'login'])

            <main class="login-main">
                <div class="login-grid animate-page-entrance">
                    <section class="hero-panel" aria-label="{{ __('messages.hero_title') }}">
                        <span class="hero-badge">
                            <i class="fa-solid fa-bolt"></i>
                            {{ __('messages.hero_badge') }}
                        </span>

                        <h1 class="hero-title">{{ __('Welcome back to your service dashboard.') }}</h1>
                        <p class="hero-copy">
                            {{ __('Log in to manage bookings, track requests, and continue where you left off with the same polished look as the homepage.') }}
                        </p>

                        <div class="feature-grid">
                            <div class="feature-card">{{ __('Manage your bookings and enquiries') }}</div>
                            <div class="feature-card">{{ __('Keep your details and history in one place') }}</div>
                            <div class="feature-card">{{ __('Return to the services page anytime') }}</div>
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

                    <section class="form-panel" aria-label="{{ __('Sign In') }}">
                        <div class="form-header">
                            <span class="form-kicker">{{ __('messages.login') }}</span>
                            <h2 class="form-title">{{ __('Welcome Back') }}</h2>
                            <p class="form-subtitle">{{ __('Log in to manage your bookings.') }}</p>
                        </div>

                        <div class="form-body">
                            <x-auth-session-status class="session-status" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="field">
                                    <div class="field-row">
                                        <x-input-label for="email" class="field-label" :value="__('Email')" />
                                        @if (Route::has('password.request'))
                                            <a class="field-help" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                                        @endif
                                    </div>
                                    <x-text-input id="email" class="control" type="email" name="email" :value="old('email')" placeholder="{{ __('name@company.com') }}" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="errors" />
                                </div>

                                <div class="field">
                                    <x-input-label for="password" class="field-label" :value="__('Password')" />
                                    <div class="password-wrap">
                                        <x-password-toggle id="password" name="password" autocomplete="current-password" required class="control" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="errors" />
                                </div>

                                <label class="remember-row">
                                    <input id="remember_me" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span>{{ __('Remember me for 30 days') }}</span>
                                </label>

                                <button type="submit" class="submit-button">{{ __('Sign In') }}</button>

                                <div class="footer-line">
                                    <span>{{ __('Don\'t have an account?') }}</span>
                                    <a href="{{ route('register') }}">{{ __('Sign Up') }}</a>
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