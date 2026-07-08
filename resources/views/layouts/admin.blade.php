<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Servicely') }} - Admin Panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

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

        <!-- Flatpickr Datepicker CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ar.js"></script>

        <!-- Global JS Translations -->
        <script>
            window.translations = {
                loading: "{{ __('messages.loading') }}",
                submitted: "{{ __('messages.submitted') }}",
                saved: "{{ __('messages.saved') }}",
                confirm_delete: "{{ __('messages.confirm_delete') }}"
            };
        </script>

        <!-- Tailwind & Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ sidebarOpen: false }">
        
        <div class="min-h-screen flex">
            
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : (app()->getLocale() === 'ar' ? 'translate-x-full' : '-translate-x-full')" 
                   class="fixed inset-y-0 start-0 z-40 w-64 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-slate-400 transform lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 flex-shrink-0 flex flex-col border-e border-slate-800 shadow-2xl">
                
                <!-- Sidebar Header/Logo -->
                <div class="h-16 px-6 flex items-center border-b border-slate-800/80">
                    <a href="/" class="flex items-center gap-2">
                        <span class="text-xl font-black bg-gradient-to-r from-teal-400 to-blue-500 bg-clip-text text-transparent">
                            SERVICELY ADMIN
                        </span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 py-6 px-4 space-y-1.5 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="{{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-teal-500/10 to-blue-500/10 text-white font-semibold border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-900 hover:text-white pl-4' }} flex items-center gap-3 py-3 rounded-lg text-sm transition">
                        <i class="fa-solid fa-chart-pie text-slate-500"></i> {{ __('messages.dashboard') }}
                    </a>

                    <!-- Service Management -->
                    <a href="{{ route('admin.services.index') }}" 
                       class="{{ request()->routeIs('admin.services.*') ? 'bg-gradient-to-r from-teal-500/10 to-blue-500/10 text-white font-semibold border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-900 hover:text-white pl-4' }} flex items-center gap-3 py-3 rounded-lg text-sm transition">
                        <i class="fa-solid fa-layer-group text-slate-500"></i> {{ __('Services') }}
                    </a>

                    <!-- Worker Management -->
                    <a href="{{ route('admin.workers.index') }}" 
                       class="{{ request()->routeIs('admin.workers.*') ? 'bg-gradient-to-r from-teal-500/10 to-blue-500/10 text-white font-semibold border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-900 hover:text-white pl-4' }} flex items-center gap-3 py-3 rounded-lg text-sm transition">
                        <i class="fa-solid fa-user-gear text-slate-500"></i> {{ __('Workers') }}
                    </a>

                    <!-- Booking Management -->
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="{{ request()->routeIs('admin.bookings.*') ? 'bg-gradient-to-r from-teal-500/10 to-blue-500/10 text-white font-semibold border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-900 hover:text-white pl-4' }} flex items-center gap-3 py-3 rounded-lg text-sm transition">
                        <i class="fa-solid fa-calendar-check text-slate-500"></i> {{ __('Bookings') }}
                    </a>

                    <!-- Enquiry Management -->
                    <a href="{{ route('admin.enquiries.index') }}" 
                       class="{{ request()->routeIs('admin.enquiries.*') ? 'bg-gradient-to-r from-teal-500/10 to-blue-500/10 text-white font-semibold border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-900 hover:text-white pl-4' }} flex items-center gap-3 py-3 rounded-lg text-sm transition">
                        <i class="fa-solid fa-envelope-open-text text-slate-500"></i> {{ __('Enquiries') }}
                    </a>

                    <!-- Admin Management (Super Admin ONLY) -->
                    @if(Auth::user()->role === 'Super Admin')
                        <div class="pt-6 pb-2 border-t border-slate-800/80 my-4">
                            <span class="text-[10px] uppercase font-bold text-slate-600 tracking-wider px-4">{{ __('System Settings') }}</span>
                        </div>
                        <a href="{{ route('admin.admins.index') }}" 
                           class="{{ request()->routeIs('admin.admins.*') ? 'bg-gradient-to-r from-teal-500/10 to-blue-500/10 text-white font-semibold border-l-4 border-teal-500 pl-3' : 'hover:bg-slate-900 hover:text-white pl-4' }} flex items-center gap-3 py-3 rounded-lg text-sm transition">
                            <i class="fa-solid fa-shield-halved text-slate-500"></i> {{ __('Administrators') }}
                        </a>
                    @endif
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-slate-800/80">
                    <div class="flex items-center gap-3 px-2 py-2">
                        <div class="h-9 w-9 rounded-full bg-slate-800 text-slate-200 flex items-center justify-center font-bold text-sm shadow-inner">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="truncate">
                            <h5 class="font-extrabold text-sm text-slate-200 truncate">{{ Auth::user()->name }}</h5>
                            <span class="text-[10px] text-teal-400 font-bold uppercase tracking-wider">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Page Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                
                <!-- Topbar Header -->
                <header class="h-16 bg-white border-b border-slate-100 px-6 flex items-center justify-between flex-shrink-0 shadow-sm">
                    <div class="flex items-center gap-4">
                        <!-- Mobile toggle -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 hover:text-slate-700">
                            <i class="fa-solid fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-base font-extrabold text-slate-700">{{ __('messages.admin_control_panel') }}</h1>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('lang.switch', app()->getLocale() === 'en' ? 'ar' : 'en') }}" class="text-xs font-bold text-slate-500 hover:text-teal-600 transition flex items-center gap-1">
                            <i class="fa-solid fa-language"></i> {{ app()->getLocale() === 'en' ? 'العربية' : 'English' }}
                        </a>
                        <span class="h-4 w-px bg-slate-200"></span>
                        <a href="/" class="text-xs font-bold text-slate-500 hover:text-teal-600 transition flex items-center gap-1">
                            <i class="fa-solid fa-globe"></i> {{ __('messages.view_site') }}
                        </a>
                        <span class="h-4 w-px bg-slate-200"></span>
                        <!-- Logout form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-slate-500 hover:text-rose-600 transition flex items-center gap-1">
                                <i class="fa-solid fa-sign-out-alt"></i> {{ __('messages.logout') }}
                            </button>
                        </form>
                    </div>
                </header>

                <!-- Page Content Slot -->
                <main class="flex-1 overflow-y-auto p-6 md:p-10">
                    {{ $slot }}
                </main>

            </div>

        </div>

    </body>
</html>
