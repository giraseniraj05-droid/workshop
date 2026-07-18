<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-house-laptop text-teal-600"></i> {{ __('messages.customer_dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 text-sm font-semibold flex items-start gap-2 shadow-sm animate-slide-down-fade">
                    <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Banner Widget -->
            <div class="bg-gradient-to-r from-teal-500 to-blue-600 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden animate-fade-in-up card-sheen">
                <div class="absolute -top-10 -end-10 w-64 h-64 bg-white/15 rounded-full blur-2xl animate-blob-slow pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.12),transparent_40%)]"></div>
                <div class="relative z-10 max-w-xl">
                    <h3 class="text-2xl font-black mb-2">{{ __('messages.welcome_back', ['name' => Auth::user()->name]) }}</h3>
                    <p class="text-teal-50/90 text-sm leading-relaxed mb-6">
                        {{ __('messages.dashboard_desc') }}
                    </p>
                    <a href="/" class="inline-block px-5 py-2.5 bg-white text-teal-700 font-bold rounded-lg hover:shadow-xl transition-all duration-200 text-sm btn-press">
                        {{ __('messages.book_new_service') }}
                    </a>
                </div>
            </div>

            <!-- Booking History Grid -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h4 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> {{ __('messages.booking_history') }}
                </h4>

                @forelse($bookings as $booking)
                    @php
                        $bookingBorder = match($booking->status) {
                            'pending' => 'card-border-amber',
                            'accepted' => 'card-border-cyber',
                            'completed' => 'card-border-emerald',
                            'rejected' => 'card-border-sunset',
                            default => 'card-border-royal'
                        };
                    @endphp
                    <div class="border border-slate-100 rounded-2xl p-6 mb-6 transition-all duration-300 flex flex-col gap-6 last:mb-0 {{ $bookingBorder }} card-sheen hover-card-lift scroll-reveal" style="transition-delay: {{ $loop->index * 70 }}ms;">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="font-extrabold text-slate-900 text-lg">
                                        {{ $booking->service->name }}
                                    </span>
                                    
                                    <!-- Localized Status Badge -->
                                    @if($booking->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold uppercase tracking-wider animate-pop-in status-badge">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                                            </span>
                                            {{ __('messages.pending') }}
                                        </span>
                                    @elseif($booking->status === 'accepted')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wider animate-pop-in status-badge">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                            </span>
                                            {{ __('messages.accepted') }}
                                        </span>
                                    @elseif($booking->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-xs font-bold uppercase tracking-wider animate-pop-in status-badge">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                                            </span>
                                            {{ __('messages.completed') }}
                                        </span>
                                    @elseif($booking->status === 'rejected')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-bold uppercase tracking-wider animate-pop-in status-badge">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                            </span>
                                            {{ __('messages.rejected') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-xs font-bold uppercase tracking-wider animate-pop-in status-badge">
                                            <span class="relative flex h-2 w-2">
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-400"></span>
                                            </span>
                                            {{ __('messages.cancelled') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 text-slate-500 text-xs font-medium">
                                    <!-- Localized Date display via Carbon -->
                                    <div>
                                        <i class="fa-solid fa-calendar mx-1 text-slate-400"></i>
                                        <span>{{ __('messages.date_label') }}</span>
                                        <span class="text-slate-800 font-semibold">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                        </span>
                                    </div>
                                    
                                    <!-- Localized Slot display -->
                                    @php
                                        $slotKey = match($booking->preferred_time) {
                                            '09:00 AM - 11:00 AM' => 'slot_morning',
                                            '11:00 AM - 01:00 PM' => 'slot_late_morning',
                                            '02:00 PM - 04:00 PM' => 'slot_afternoon',
                                            '04:00 PM - 06:00 PM' => 'slot_evening',
                                            default => null
                                        };
                                    @endphp
                                    <div>
                                        <i class="fa-solid fa-clock mx-1 text-slate-400"></i>
                                        <span>{{ __('messages.slot_label') }}</span>
                                        <span class="text-slate-800 font-semibold">
                                            {{ $slotKey ? __('messages.' . $slotKey) : $booking->preferred_time }}
                                        </span>
                                    </div>
                                    
                                    <div class="col-span-full mt-1">
                                        <i class="fa-solid fa-location-dot mx-1 text-slate-400"></i>
                                        <span>{{ __('messages.address_label') }}</span>
                                        <span class="text-slate-800 font-semibold">{{ $booking->address }}</span>
                                    </div>
                                    
                                    @if($booking->notes)
                                        <div class="col-span-full mt-1">
                                            <i class="fa-solid fa-comment mx-1 text-slate-400"></i>
                                            <span>{{ __('messages.notes_label') }}</span>
                                            <span class="text-slate-800 italic">"{{ $booking->notes }}"</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Assigned Worker info (Logical border and padding: md:ps-6 md:border-s) -->
                            <div class="pt-4 md:pt-0 md:ps-6 border-t md:border-t-0 md:border-s border-slate-100 flex items-center gap-4 min-w-[240px] w-full md:w-auto">
                                <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold overflow-hidden shadow-inner flex-shrink-0">
                                    @if($booking->worker && $booking->worker->workerProfile && $booking->worker->workerProfile->photo)
                                        <img src="{{ asset('storage/' . $booking->worker->workerProfile->photo) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        <i class="fa-solid fa-user text-slate-400"></i>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">{{ __('messages.assigned_specialist_lbl') }}</span>
                                    <span class="font-bold text-slate-800 text-sm">
                                        {{ $booking->worker->name ?? __('messages.awaiting_assignment') }}
                                    </span>
                                    @if($booking->worker && $booking->worker->workerProfile)
                                        <span class="text-xs text-slate-500 block">
                                            <span>{{ __('messages.phone_label') }}</span>
                                            <span>{{ $booking->worker->workerProfile->phone }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Feedback & Ratings Block -->
                        @if($booking->status === 'completed')
                            <div class="mt-2 pt-4 border-t border-slate-100">
                                @if(!$booking->feedback)
                                    <form action="{{ route('feedback.store', $booking->id) }}" method="POST" class="space-y-4" x-data="{ rating: 5, hover: 0 }">
                                        @csrf
                                        <div class="flex flex-col gap-2">
                                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">{{ __('messages.leave_review') }}</span>
                                            <div class="flex items-center gap-1.5">
                                                <template x-for="i in 5">
                                                    <button type="button" 
                                                        @click="rating = i" 
                                                        @mouseenter="hover = i" 
                                                        @mouseleave="hover = 0"
                                                        class="text-2xl focus:outline-none transition hover:scale-110 star-rating-btn">
                                                        <i class="fa-star" :class="i <= (hover || rating) ? 'fa-solid text-amber-400' : 'fa-regular text-slate-300'"></i>
                                                    </button>
                                                </template>
                                                <input type="hidden" name="rating" :value="rating">
                                            </div>
                                        </div>

                                        <div class="flex flex-col gap-1.5">
                                            <textarea name="comment" rows="2" placeholder="{{ __('messages.your_review') }}" 
                                                class="w-full text-sm border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition"></textarea>
                                        </div>

                                        <button type="submit" class="px-5 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-xs transition shadow-sm hover:shadow btn-press">
                                            {{ __('messages.submit_review') }}
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex flex-col gap-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $booking->feedback->rating)
                                                        <i class="fa-solid fa-star text-amber-400 text-sm"></i>
                                                    @else
                                                        <i class="fa-regular fa-star text-slate-300 text-sm"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                                {{ $booking->feedback->created_at->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                        @if($booking->feedback->comment)
                                            <p class="text-sm text-slate-600 italic">"{{ $booking->feedback->comment }}"</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fa-solid fa-calendar-times text-4xl text-slate-200 mb-3 block"></i>
                        <p class="text-slate-500 font-semibold mb-4">{{ __('messages.no_bookings') }}</p>
                        <a href="/" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-50 hover:bg-teal-100 text-teal-700 font-bold rounded-xl transition">
                            {{ __('messages.book_first_service') }} <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
