<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.app_name') }} - On-Demand Services</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @if(app()->getLocale() === 'ar')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body, input, select, textarea, button {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
    @endif

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Tailwind CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .login-header {
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
        .login-header .brand { display: flex; align-items: center; gap: 14px; text-decoration: none; color: inherit; }
        .login-header .brand-mark {
            width: 44px; height: 44px; display: grid; place-items: center; border-radius: 14px;
            background: linear-gradient(135deg, #1e40af, #d97706);
            color: white; font-weight: 800; box-shadow: 0 12px 28px rgba(30, 64, 175, 0.18);
        }
        .login-header .brand-name { font-size: 1rem; font-weight: 900; letter-spacing: 0.16em; text-transform: uppercase; color: #172554; }
        .login-header .header-actions { display: flex; align-items: center; gap: 12px; }
        .login-header .lang-pill, .login-header .header-link {
            display: inline-flex; align-items: center; gap: 8px; border-radius: 999px;
            text-decoration: none; font-weight: 700;
        }
        .login-header .lang-pill { padding: 10px 16px; border: 1px solid rgba(148, 163, 184, 0.35); color: #475569; background: rgba(255, 255, 255, 0.75); }
        .login-header .header-link { padding: 10px 18px; color: #0f172a; background: white; box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08); }
        .login-header .header-link.is-active { color: white; background: linear-gradient(135deg, #1e40af, #d97706); }

        .page-footer { margin-top: auto; border-top: 1px solid #1e293b; background: #0f172a; color: #94a3b8; padding: 48px 24px; }
        .page-footer-inner { width: min(1280px, 100%); margin: 0 auto; display: flex; flex-direction: column; gap: 18px; align-items: center; justify-content: space-between; text-align: center; }
        .page-footer-brand { color: white; font-size: 1.25rem; font-weight: 900; letter-spacing: 0.18em; }
        .page-footer-copy { margin: 0; font-size: 0.95rem; line-height: 1.7; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

    
    @include('partials.site-header', ['page' => 'home'])

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-teal-500 via-blue-600 to-indigo-700 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_40%)]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">
                {{ __('messages.hero_badge') }}
            </span>
            <h1 class="text-4xl md:text-6xl font-black tracking-tight mb-6 max-w-4xl mx-auto leading-tight">
                {{ __('messages.hero_title') }}
            </h1>
            <p class="text-lg md:text-xl text-teal-50/95 max-w-2xl mx-auto mb-10 font-medium">
                {{ __('messages.hero_subtitle') }}
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#services-list" class="px-8 py-4 bg-white text-blue-700 font-bold rounded-xl shadow-lg hover:shadow-xl transition hover:-translate-y-0.5">
                    {{ __('messages.browse_services_btn') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services-list" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-4">
                {{ __('messages.our_services') }}
            </h2>
            <p class="text-slate-500 max-w-xl mx-auto">
                {{ __('messages.services_subtitle') }}
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($services as $service)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:border-teal-200 transition-all duration-300 flex flex-col group">

                <!-- Hero Image -->
                <div class="h-48 overflow-hidden bg-slate-100 relative">
                    <div class="absolute inset-0 bg-slate-800/10 group-hover:bg-slate-800/0 transition-all duration-300"></div>
                    <img src="{{ $service->image ? (str_starts_with($service->image, 'images/') ? asset($service->image) : asset('storage/' . $service->image)) : asset('images/service-placeholder.png') }}"
                        alt="{{ $service->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500" />

                    <!-- Icon badge (logical positioning start-4) -->
                    <div class="absolute bottom-4 start-4 h-12 w-12 rounded-xl bg-white shadow-md flex items-center justify-center text-teal-600">
                        @if($service->icon === 'sparkles')
                        <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
                        @elseif($service->icon === 'grid')
                        <i class="fa-solid fa-table-cells text-xl"></i>
                        @elseif($service->icon === 'paint-brush')
                        <i class="fa-solid fa-paint-roller text-xl"></i>
                        @elseif($service->icon === 'layer-group')
                        <i class="fa-solid fa-layer-group text-xl"></i>
                        @elseif($service->icon === 'hammer')
                        <i class="fa-solid fa-hammer text-xl"></i>
                        @elseif($service->icon === 'droplet')
                        <i class="fa-solid fa-droplet text-xl"></i>
                        @elseif($service->icon === 'square')
                        <i class="fa-solid fa-border-all text-xl"></i>
                        @else
                        <i class="fa-solid fa-screwdriver-wrench text-xl"></i>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="font-bold text-lg text-slate-900 group-hover:text-teal-600 transition mb-2">
                        {{ $service->name }}
                    </h3>
                    <p class="text-slate-500 text-sm line-clamp-3 mb-6">
                        {{ $service->description }}
                    </p>

                    <!-- Price & Button -->
                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-400 block font-semibold uppercase tracking-wider">{{ __('messages.starting_from') }}</span>
                            <span class="text-lg font-extrabold text-slate-800">${{ number_format($service->price, 2) }}</span>
                        </div>
                        <a href="{{ route('services.show', $service->slug) }}"
                            class="px-4 py-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-600 font-bold rounded-lg text-sm transition shadow-sm">
                            {{ __('messages.view_details') }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fa-solid fa-sad-tear text-4xl text-slate-300 mb-4 block"></i>
                <p class="text-slate-500 font-medium">{{ __('messages.no_services') }}</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- <x-site-footer /> -->
    @include('partials.site-footer')


</body>

</html>