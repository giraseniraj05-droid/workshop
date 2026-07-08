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
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        
        <!-- Header / Navigation -->
        <header class="bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <span class="text-2xl font-black bg-gradient-to-r from-teal-500 to-blue-600 bg-clip-text text-transparent">
                        {{ __('messages.app_name') }}
                    </span>
                </a>

                <!-- Navigation Links -->
                <nav class="flex items-center gap-4">
                    <!-- Language switcher -->
                    <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}" class="px-3 py-2 text-sm font-semibold text-slate-500 hover:text-teal-600 transition flex items-center gap-1">
                        <i class="fa-solid fa-language"></i> {{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}
                    </a>
                    <span class="h-4 w-px bg-slate-200"></span>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-teal-600 transition">
                                {{ __('messages.dashboard') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded-lg transition shadow-sm">
                                    {{ __('messages.logout') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-teal-600 transition">
                                {{ __('messages.login') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 rounded-lg transition shadow-sm">
                                    {{ __('messages.register') }}
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

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
                            <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=600" 
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

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-400 py-12 mt-20 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <span class="text-xl font-black text-white tracking-wider">
                    {{ __('messages.app_name') }}
                </span>
                <p class="text-sm">
                    &copy; {{ date('Y') }} {{ __('messages.app_name') }}. All rights reserved. Urban Company-inspired Marketplace.
                </p>
            </div>
        </footer>

    </body>
</html>
