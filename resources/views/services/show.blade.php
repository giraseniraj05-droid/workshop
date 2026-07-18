<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $service->name }} - {{ __('messages.app_name') }}</title>
        
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

        <!-- Tailwind CSS & Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ activeForm: 'book' }">
        
        <!-- Header -->
        @include('partials.site-header', ['page' => 'services'])

        <!-- Service Hero Section -->
        <section class="bg-slate-900 text-white py-16 relative overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ $service->image ? (str_starts_with($service->image, 'images/') ? asset($service->image) : asset('storage/' . $service->image)) : asset('images/service-placeholder.png') }}');"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="px-3 py-1 bg-teal-500/20 text-teal-400 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">
                        {{ __('messages.category') }}
                    </span>
                    <h1 class="text-3xl md:text-5xl font-black mb-6 leading-tight">
                        {{ $service->name }}
                    </h1>
                    <p class="text-slate-300 text-base md:text-lg mb-8 leading-relaxed">
                        {{ $service->description }}
                    </p>
                    <div class="flex items-center gap-6 mt-6 flex-wrap">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400 text-sm font-semibold">{{ __('messages.starting_from') }}:</span>
                            <span class="text-2xl font-extrabold text-teal-400">${{ number_format($service->price, 2) }}</span>
                        </div>
                        @if($reviewsCount > 0)
                            <div class="flex items-center gap-2 bg-white/15 px-3 py-1.5 rounded-xl backdrop-blur-sm">
                                <div class="flex items-center gap-0.5 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($averageRating))
                                            <i class="fa-solid fa-star text-xs"></i>
                                        @else
                                            <i class="fa-regular fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-teal-300 font-extrabold text-sm">{{ number_format($averageRating, 1) }}</span>
                                <span class="text-slate-400 text-xs">({{ $reviewsCount }} {{ trans_choice('messages.reviews', $reviewsCount) }})</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Side: Workers Listing -->
            <section class="lg:col-span-2">
                <h2 class="text-2xl font-black text-slate-900 mb-8 flex items-center gap-2">
                    <i class="fa-solid fa-user-tie text-teal-600"></i> {{ __('messages.assigned_specialists') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($workers as $worker)
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col card-border-emerald smooth-card-motion scroll-reveal">
                            <!-- Photo and Name -->
                            <div class="flex items-center gap-4 mb-4">
                                <div class="h-16 w-16 rounded-full bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 font-bold overflow-hidden shadow-inner flex-shrink-0">
                                    @if($worker->workerProfile && $worker->workerProfile->photo)
                                        <img src="{{ asset('storage/' . $worker->workerProfile->photo) }}" class="w-full h-full object-cover" alt="{{ $worker->name }}">
                                    @else
                                        {{ substr($worker->name, 0, 2) }}
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">{{ $worker->name }}</h3>
                                    <p class="text-xs text-teal-600 font-bold flex items-center gap-1">
                                        <i class="fa-solid fa-star text-yellow-400"></i>
                                        <span>{{ __('messages.experience_label') }}</span>
                                        <span>{{ __('messages.years_experience', ['count' => $worker->workerProfile->experience ?? 0]) }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Skills / Tags -->
                            @if($worker->workerProfile && $worker->workerProfile->skills)
                                <div class="mb-4">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">{{ __('messages.skills_label') }}</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($worker->workerProfile->skills as $skill)
                                            <span class="px-2 py-0.5 bg-slate-50 border border-slate-100 text-slate-600 rounded-md text-[10px] font-semibold">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Biography -->
                            <p class="text-slate-550 text-xs leading-relaxed mb-6">
                                {{ $worker->workerProfile->bio ?? 'Verified Reahan Alfrah specialist.' }}
                            </p>

                            <!-- Social Links -->
                            @if($worker->workerProfile)
                                <div class="mt-auto pt-4 border-t border-slate-50">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-2">{{ __('messages.social_profiles_label') }}</span>
                                    <div class="flex items-center gap-3">
                                        @if($worker->workerProfile->linkedin)
                                            <a href="{{ $worker->workerProfile->linkedin }}" target="_blank" class="text-slate-400 hover:text-blue-600 transition text-sm">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        @endif
                                        @if($worker->workerProfile->facebook)
                                            <a href="{{ $worker->workerProfile->facebook }}" target="_blank" class="text-slate-400 hover:text-blue-700 transition text-sm">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if($worker->workerProfile->instagram)
                                            <a href="{{ $worker->workerProfile->instagram }}" target="_blank" class="text-slate-400 hover:text-pink-600 transition text-sm">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full bg-white p-8 border border-slate-100 rounded-2xl text-center">
                            <i class="fa-solid fa-users-slash text-slate-300 text-4xl mb-3 block"></i>
                            <p class="text-slate-500 font-semibold">{{ __('messages.no_specialists') }}</p>
                        </div>
                    @endforelse
                </div>

                <!-- Reviews Section -->
                <div class="mt-12 pt-12 border-t border-slate-200">
                    <h2 class="text-2xl font-black text-slate-900 mb-8 flex items-center gap-2">
                        <i class="fa-solid fa-star text-amber-500"></i> {{ __('messages.reviews') }}
                        @if($reviewsCount > 0)
                            <span class="text-slate-400 font-medium text-base">({{ $reviewsCount }})</span>
                        @endif
                    </h2>

                    @forelse($reviews as $review)
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm mb-6 last:mb-0 card-border-amber smooth-card-motion scroll-reveal">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-600 font-bold overflow-hidden shadow-inner flex-shrink-0">
                                        {{ substr($review->customer->name ?? 'User', 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-slate-900 text-sm">{{ $review->customer->name ?? 'Deleted User' }}</h4>
                                        <div class="flex items-center gap-0.5 mt-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-slate-200 text-xs"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    {{ $review->created_at->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            @if($review->comment)
                                <p class="text-slate-600 text-sm leading-relaxed italic">"{{ $review->comment }}"</p>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white p-8 border border-slate-100 rounded-2xl text-center">
                            <i class="fa-solid fa-comments text-slate-300 text-4xl mb-3 block"></i>
                            <p class="text-slate-500 font-semibold">{{ __('messages.no_reviews') }}</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Right Side: Forms (Booking & Enquiry) -->
            <section class="lg:col-span-1">
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
                    
                    <!-- Tabs Header -->
                    <div class="flex border-b border-slate-100 bg-slate-50">
                        <button @click="activeForm = 'book'" 
                                :class="activeForm === 'book' ? 'bg-white border-b-2 border-teal-500 text-teal-600' : 'text-slate-500 hover:text-slate-800'"
                                class="flex-1 py-4 text-sm font-bold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-calendar-check"></i> {{ __('messages.book_now_tab') }}
                        </button>
                        <button @click="activeForm = 'enquire'" 
                                :class="activeForm === 'enquire' ? 'bg-white border-b-2 border-teal-500 text-teal-600' : 'text-slate-500 hover:text-slate-800'"
                                class="flex-1 py-4 text-sm font-bold transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-envelope-open-text"></i> {{ __('messages.enquire_tab') }}
                        </button>
                    </div>

                    <!-- Tabs Body -->
                    <div class="p-6">
                        
                        <!-- 1. Booking Form -->
                        <div x-show="activeForm === 'book'" x-transition>
                            @auth
                                <form method="POST" action="{{ route('bookings.store', $service->id) }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                                    <!-- Preferred Date (Flatpickr) -->
                                    <div>
                                        <label for="booking_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.pref_date') }}</label>
                                        <input type="text" name="booking_date" id="booking_date" required placeholder="YYYY-MM-DD"
                                               class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium input-focus-glow">
                                        @error('booking_date')
                                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Preferred Time Slot -->
                                    <div>
                                        <label for="preferred_time" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.pref_time') }}</label>
                                        <select name="preferred_time" id="preferred_time" required
                                                class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                                            <option value="09:00 AM - 11:00 AM">{{ __('messages.slot_morning', [], app()->getLocale()) }}</option>
                                            <option value="11:00 AM - 01:00 PM">{{ __('messages.slot_late_morning', [], app()->getLocale()) }}</option>
                                            <option value="02:00 PM - 04:00 PM">{{ __('messages.slot_afternoon', [], app()->getLocale()) }}</option>
                                            <option value="04:00 PM - 06:00 PM">{{ __('messages.slot_evening', [], app()->getLocale()) }}</option>
                                        </select>
                                    </div>

                                    <!-- Choose Specialist -->
                                    <div>
                                        <label for="worker_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.choose_professional') }}</label>
                                        <select name="worker_id" id="worker_id"
                                                class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                                            <option value="">{{ __('messages.any_specialist') }}</option>
                                            @foreach($workers as $worker)
                                                <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Address -->
                                    <div>
                                        <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.service_address') }}</label>
                                                                                <input type="text" name="address" id="address" required placeholder="{{ __('messages.address_placeholder') }}"
                                               class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                                        @error('address')
                                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.special_instructions') }}</label>
                                        <textarea name="notes" id="notes" rows="3" placeholder="Any specific details..."
                                                  class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 text-sm font-medium"></textarea>
                                    </div>

                                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white font-bold rounded-xl transition duration-200 shadow-md btn-press">
                                        {{ __('messages.request_booking') }}
                                    </button>

                                    <p class="text-[10px] text-slate-400 text-center leading-relaxed">
                                        {{ __('messages.booking_note') }}
                                    </p>
                                </form>
                            @else
                                <div class="text-center py-6">
                                    <h4 class="font-extrabold text-slate-800 text-base mb-2">{{ __('messages.login_required_title') }}</h4>
                                    <p class="text-slate-500 text-xs mb-6 px-4">
                                        {{ __('messages.login_required_desc') }}
                                    </p>
                                    <div class="flex flex-col gap-3">
                                        <a href="{{ route('login') }}" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition text-sm">
                                            {{ __('messages.login_to_book_btn') }}
                                        </a>
                                        <a href="{{ route('register') }}" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition text-sm">
                                            {{ __('messages.create_account_btn') }}
                                        </a>
                                    </div>
                                </div>
                            @endauth
                        </div>

                        <!-- 2. Enquiry Form -->
                        <div x-show="activeForm === 'enquire'" x-transition>
                            <form method="POST" action="{{ route('enquiries.store', $service->id) }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                <!-- Name -->
                                <div>
                                    <label for="customer_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.full_name') }}</label>
                                                                            <input type="text" name="customer_name" id="customer_name" required placeholder="{{ __('messages.full_name_placeholder') }}"
                                           value="{{ old('customer_name', Auth::user()->name ?? '') }}"
                                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                                    @error('customer_name')
                                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.email') }}</label>
                                                                            <input type="email" name="email" id="email" required placeholder="{{ __('messages.email_placeholder') }}"
                                           value="{{ old('email', Auth::user()->email ?? '') }}"
                                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                                    @error('email')
                                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.phone') }}</label>
                                                                            <input type="text" name="phone" id="phone" required placeholder="{{ __('messages.phone_placeholder') }}"
                                           value="{{ old('phone', Auth::user()->workerProfile->phone ?? '') }}"
                                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                                    @error('phone')
                                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.enquiry_msg') }}</label>
                                    <textarea name="message" id="message" rows="4" required placeholder="Ask us anything about this service..."
                                              class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 text-sm font-medium"></textarea>
                                    @error('message')
                                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="w-full py-3.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition duration-200 shadow-md btn-press">
                                    {{ __('messages.submit_enquiry') }}
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </section>

        </main>

        @include('partials.site-footer')

        <!-- Initialize Flatpickr -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr("#booking_date", {
                    locale: "{{ app()->getLocale() === 'ar' ? 'ar' : 'default' }}",
                    minDate: "today",
                    dateFormat: "Y-m-d"
                });
            });
        </script>
    </body>
</html>
