<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-blue-600"></i> {{ __('messages.worker_portal') }}
            </span>
            <a href="{{ route('worker.profile.edit') }}" class="px-4 py-2 text-sm bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold rounded-lg transition shadow-sm btn-press">
                <i class="fa-solid fa-user-edit mr-1"></i> {{ __('messages.edit_profile') }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Welcome Widget -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_40%)]"></div>
                <div class="relative z-10 max-w-xl">
                    <h3 class="text-2xl font-black mb-2">{{ __('messages.worker_welcome', ['name' => Auth::user()->name]) }}</h3>
                    <p class="text-blue-50/90 text-sm leading-relaxed">
                        {{ __('messages.worker_desc') }}
                    </p>
                </div>
            </div>

            <!-- Dashboard Split Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Assigned Services -->
                <div class="lg:col-span-1 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col">
                    <h4 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-blue-600"></i> {{ __('messages.my_services') }}
                    </h4>
                    <p class="text-slate-500 text-xs mb-4">{{ __('messages.assigned_services_desc') }}</p>
                    
                    <div class="space-y-3 flex-1">
                        @forelse($assignedServices as $service)
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3 hover-card-lift">
                                <div class="h-10 w-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i class="fa-solid fa-screwdriver-wrench"></i>
                                </div>
                                <span class="font-bold text-slate-800 text-sm">{{ $service->name }}</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-400">
                                <i class="fa-solid fa-triangle-exclamation text-3xl mb-2"></i>
                                <p class="text-xs font-semibold">{{ __('messages.no_assigned_services') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right: Upcoming Jobs -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                    <h4 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list text-blue-600"></i> {{ __('messages.my_bookings') }}
                    </h4>

                    <div class="space-y-4">
                        @forelse($bookings as $booking)
                            <div class="border border-slate-100 rounded-2xl p-6 transition flex flex-col md:flex-row justify-between gap-6 hover-card-lift scroll-reveal card-border-royal card-sheen" style="transition-delay: {{ $loop->index * 70 }}ms;">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-base">{{ $booking->service->name }}</span>
                                        
                                        <!-- Localized Status Badge -->
                                        @if($booking->status === 'pending')
                                            <span class="px-2 py-0.5 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-[10px] font-bold uppercase tracking-wider status-badge">
                                                {{ __('messages.pending') }}
                                            </span>
                                        @elseif($booking->status === 'accepted')
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[10px] font-bold uppercase tracking-wider status-badge">
                                                {{ __('messages.accepted') }}
                                            </span>
                                        @elseif($booking->status === 'completed')
                                            <span class="px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[10px] font-bold uppercase tracking-wider status-badge">
                                                {{ __('messages.completed') }}
                                            </span>
                                        @elseif($booking->status === 'rejected')
                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-[10px] font-bold uppercase tracking-wider status-badge">
                                                {{ __('messages.rejected') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-[10px] font-bold uppercase tracking-wider status-badge">
                                                {{ __('messages.cancelled') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs font-semibold text-slate-500">
                                        <!-- Customer name (not translated) -->
                                        <div>
                                            <i class="fa-solid fa-user text-slate-400 mx-1"></i>
                                            <span>{{ __('messages.customer_label') }}</span>
                                            <span class="text-slate-800">{{ $booking->customer->name }}</span>
                                        </div>
                                        
                                        <!-- Phone -->
                                        <div>
                                            <i class="fa-solid fa-phone text-slate-400 mx-1"></i>
                                            <span>{{ __('messages.phone_label') }}</span>
                                            <span class="text-slate-800">{{ $booking->customer->workerProfile->phone ?? 'N/A' }}</span>
                                        </div>
                                        
                                        <!-- Date (Carbon localized) -->
                                        <div>
                                            <i class="fa-solid fa-calendar text-slate-400 mx-1"></i>
                                            <span>{{ __('messages.date_label') }}</span>
                                            <span class="text-slate-800">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                            </span>
                                        </div>
                                        
                                        <!-- Slot mapping -->
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
                                            <i class="fa-solid fa-clock text-slate-400 mx-1"></i>
                                            <span>{{ __('messages.slot_label') }}</span>
                                            <span class="text-slate-800">
                                                {{ $slotKey ? __('messages.' . $slotKey) : $booking->preferred_time }}
                                            </span>
                                        </div>
                                        
                                        <div class="col-span-full">
                                            <i class="fa-solid fa-location-dot text-slate-400 mx-1"></i>
                                            <span>{{ __('messages.address_label') }}</span>
                                            <span class="text-slate-800">{{ $booking->address }}</span>
                                        </div>
                                        
                                        @if($booking->notes)
                                            <div class="col-span-full">
                                                <i class="fa-solid fa-comment text-slate-400 mx-1"></i>
                                                <span>{{ __('messages.notes_label') }}</span>
                                                <span class="text-slate-800 italic">"{{ $booking->notes }}"</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 text-slate-400">
                                <i class="fa-solid fa-mug-hot text-4xl mb-3 block"></i>
                                <p class="text-slate-500 font-semibold">{{ __('messages.no_assigned_bookings') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
