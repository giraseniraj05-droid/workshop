<x-admin-layout>
    
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">{{ __('messages.manage_booking') }}</h2>
            <p class="text-slate-500 text-sm font-medium">Verify, assign professional, or modify booking status.</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> {{ __('messages.bookings') }}
        </a>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Side: Booking & Customer Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                <!-- Header with Status Badge -->
                <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                    <h3 class="text-xl font-bold text-slate-900">{{ $booking->service->name }}</h3>
                    
                    @if($booking->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ __('messages.pending') }}
                        </span>
                    @elseif($booking->status === 'accepted')
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ __('messages.accepted') }}
                        </span>
                    @elseif($booking->status === 'completed')
                        <span class="px-3 py-1 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ __('messages.completed') }}
                        </span>
                    @elseif($booking->status === 'rejected')
                        <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ __('messages.rejected') }}
                        </span>
                    @else
                        <span class="px-3 py-1 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ __('messages.cancelled') }}
                        </span>
                    @endif
                </div>

                <!-- Booking Meta Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">{{ __('messages.customer_label') }}</span>
                        <span class="font-extrabold text-slate-800 text-sm"><i class="fa-solid fa-user text-slate-350 mr-1.5 text-xs"></i> {{ $booking->customer->name }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">{{ __('messages.email_label') }}</span>
                        <span class="font-extrabold text-slate-800 text-sm"><i class="fa-solid fa-envelope text-slate-350 mr-1.5 text-xs"></i> {{ $booking->customer->email }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">{{ __('messages.date_label') }}</span>
                        <span class="font-extrabold text-slate-800 text-sm"><i class="fa-solid fa-calendar text-slate-350 mr-1.5 text-xs"></i> {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    
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
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">{{ __('messages.slot_label') }}</span>
                        <span class="font-extrabold text-slate-800 text-sm"><i class="fa-solid fa-clock text-slate-350 mr-1.5 text-xs"></i> {{ $slotKey ? __('messages.' . $slotKey) : $booking->preferred_time }}</span>
                    </div>
                    
                    <div class="col-span-full">
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">{{ __('messages.address_label') }}</span>
                        <span class="font-bold text-slate-800 text-sm leading-relaxed"><i class="fa-solid fa-location-dot text-slate-350 mr-1.5 text-sm"></i> {{ $booking->address }}</span>
                    </div>
                    @if($booking->notes)
                        <div class="col-span-full">
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">{{ __('messages.notes_label') }}</span>
                            <span class="font-semibold text-slate-700 italic text-sm">"{{ $booking->notes }}"</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side: Assign & Status Form -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm h-fit">
                <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-50 pb-4">
                    <i class="fa-solid fa-user-edit text-teal-600 mr-1"></i> Update Booking
                </h3>

                <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Assign Worker -->
                    <div>
                        <label for="worker_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.column_worker') }}</label>
                        <select name="worker_id" id="worker_id"
                                class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 text-sm font-semibold">
                            <option value="">{{ __('messages.unassigned_label') }}</option>
                            @foreach($workers as $worker)
                                <option value="{{ $worker->id }}" {{ $booking->worker_id === $worker->id ? 'selected' : '' }}>
                                    {{ $worker->name }} ({{ $worker->workerProfile->experience ?? 0 }} yrs exp)
                                </option>
                            @endforeach
                        </select>
                        <span class="text-[10px] text-slate-400 block mt-1">Only active specialists assigned to the service category are listed.</span>
                    </div>

                    <!-- Change Status -->
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.column_status') }}</label>
                        <select name="status" id="status" required
                                class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 text-sm font-semibold">
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                            <option value="accepted" {{ $booking->status === 'accepted' ? 'selected' : '' }}>{{ __('messages.accepted') }}</option>
                            <option value="rejected" {{ $booking->status === 'rejected' ? 'selected' : '' }}>{{ __('messages.rejected') }}</option>
                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-teal-500 hover:bg-teal-600 text-white font-bold rounded-xl transition shadow-sm">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-admin-layout>
