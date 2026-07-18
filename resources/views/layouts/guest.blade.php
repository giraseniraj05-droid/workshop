@props(['page' => null])

@php
$heroTitle = $page === 'register'
? __('Create your account in minutes.')
: __('Welcome back to your service dashboard.');

$heroSubtitle = $page === 'register'
? __('Join a cleaner, faster way to book trusted home services with a setup that feels as polished as the homepage.')
: __('Log in to manage bookings, track requests, and continue where you left off without losing the visual rhythm of the main site.');

$heroPoints = $page === 'register'
? [
__('Quick booking from any device'),
__('Trusted professionals and clear pricing'),
__('A smoother start than the old form layout'),
]
: [
__('Manage your bookings and enquiries'),
__('Keep your details and history in one place'),
__('Return to the services page anytime'),
];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/company-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @if (app()->getLocale() === 'ar')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body,
        input,
        select,
        textarea,
        button {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
    @endif
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
            accent-color: var(--login-primary);
        }

        .submit-button {
            width: 100%;
            min-height: 48px;
            border: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--login-primary), var(--login-accent));
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

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-900">
    <div class="relative min-h-screen overflow-hidden bg-slate-50">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-24 top-20 h-[32rem] w-[32rem] rounded-full bg-teal-500/20 blur-3xl"></div>
            <div class="absolute right-[-10rem] top-24 h-[30rem] w-[30rem] rounded-full bg-blue-600/20 blur-3xl"></div>
            <div class="absolute inset-x-1/2 top-56 h-72 w-72 -translate-x-1/2 rounded-full bg-indigo-500/10 blur-3xl"></div>
        </div>

        <div class="relative z-10 flex min-h-screen flex-col">
            @include('partials.site-header', ['page' => 'home'])

            <main class="flex flex-1 items-center px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
                <div class="mx-auto grid w-full max-w-7xl gap-8 {{ $page === 'login' ? '' : 'lg:grid-cols-[1.05fr_0.95fr]' }} lg:gap-12 xl:gap-16">
                    @if ($page !== 'login')
                    <section class="relative hidden overflow-hidden rounded-[2rem] bg-gradient-to-br from-teal-500 via-blue-600 to-indigo-700 p-8 text-white shadow-2xl shadow-blue-950/20 lg:flex lg:min-h-[38rem] lg:flex-col lg:justify-between xl:p-12">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.18),transparent_35%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.12),transparent_30%)]"></div>

                        <div class="relative space-y-6">
                            <span class="inline-flex rounded-full bg-white/20 px-4 py-1 text-xs font-bold uppercase tracking-[0.3em] text-white/95">
                                {{ __('messages.hero_badge') }}
                            </span>
                            <h1 class="max-w-lg text-4xl font-black leading-tight xl:text-5xl">
                                {{ $heroTitle }}
                            </h1>
                            <p class="max-w-xl text-base leading-7 text-teal-50/95 xl:text-lg">
                                {{ $heroSubtitle }}
                            </p>
                        </div>

                        <div class="relative grid gap-4 rounded-[1.75rem] border border-white/15 bg-white/10 p-5 backdrop-blur-sm sm:grid-cols-3">
                            @foreach ($heroPoints as $point)
                            <div class="rounded-2xl bg-white/10 p-4 text-sm font-medium leading-6 text-white/95">
                                {{ $point }}
                            </div>
                            @endforeach
                        </div>

                        <div class="relative flex flex-wrap gap-3">
                            <a href="{{ route('home') }}#services-list" class="inline-flex items-center rounded-xl bg-white px-6 py-3 font-bold text-blue-700 shadow-lg shadow-blue-950/15 hover:bg-teal-50">
                                {{ __('messages.browse_services_btn') }}
                            </a>
                            <a href="{{ route('home') }}" class="inline-flex items-center rounded-xl border border-white/25 bg-white/10 px-6 py-3 font-semibold text-white backdrop-blur hover:bg-white/15">
                                {{ __('messages.app_name') }}
                            </a>
                        </div>
                    </section>
                    @endif

                    <div class="space-y-6 {{ $page === 'login' ? 'mx-auto w-full max-w-5xl' : '' }}">
                        @if ($page !== 'login')
                        <section class="overflow-hidden rounded-[2rem] bg-gradient-to-br from-teal-500 via-blue-600 to-indigo-700 p-6 text-white shadow-2xl shadow-blue-950/20 lg:hidden">
                            <span class="inline-flex rounded-full bg-white/20 px-4 py-1 text-[11px] font-bold uppercase tracking-[0.28em] text-white/95">
                                {{ __('messages.hero_badge') }}
                            </span>
                            <h1 class="mt-4 text-3xl font-black leading-tight sm:text-4xl">
                                {{ $heroTitle }}
                            </h1>
                            <p class="mt-4 text-sm leading-6 text-teal-50/95 sm:text-base">
                                {{ $heroSubtitle }}
                            </p>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('home') }}#services-list" class="inline-flex items-center rounded-xl bg-white px-5 py-3 text-sm font-bold text-blue-700 shadow-lg shadow-blue-950/15">
                                    {{ __('messages.browse_services_btn') }}
                                </a>
                                <a href="{{ route('home') }}" class="inline-flex items-center rounded-xl border border-white/25 bg-white/10 px-5 py-3 text-sm font-semibold text-white backdrop-blur">
                                    {{ __('messages.app_name') }}
                                </a>
                            </div>
                        </section>
                        @endif

                        <div class="mx-auto w-full max-w-xl">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>

            @include('partials.site-footer')

        </div>
    </div>
</body>

</html>