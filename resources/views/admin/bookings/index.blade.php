<x-admin-layout>
    
    <div class="mb-8">
        <h2 class="text-3xl font-black text-slate-900 mb-1">{{ __('messages.bookings') }}</h2>
        <p class="text-slate-500 text-sm font-medium">{{ __('messages.admin_bookings_desc') }}</p>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm mb-8">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.status_label') }}</label>
                <select name="status" id="status"
                        class="w-full rounded-xl border-slate-200 focus:border-teal-500 text-slate-800 text-sm font-semibold">
                    <option value="">{{ __('messages.all_statuses') }}</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>{{ __('messages.accepted') }}</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('messages.rejected') }}</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
                </select>
            </div>

            <!-- Service Category Filter -->
            <div>
                <label for="service_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.column_service') }}</label>
                <select name="service_id" id="service_id"
                        class="w-full rounded-xl border-slate-200 focus:border-teal-500 text-slate-800 text-sm font-semibold">
                    <option value="">{{ __('messages.all_services') }}</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') === $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range -->
            <div class="md:col-span-2 grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.start_date_label') }}</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 text-slate-850 text-sm font-medium">
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.end_date_label') }}</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 text-slate-850 text-sm font-medium">
                </div>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex justify-end gap-3 pt-4 border-t border-slate-50">
                <a href="{{ route('admin.bookings.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-700 font-bold rounded-lg text-xs hover:bg-slate-200 transition">
                    {{ __('messages.clear_filters') }}
                </a>
                <button type="submit" class="px-5 py-2.5 bg-teal-500 text-white font-bold rounded-lg text-xs hover:bg-teal-600 transition shadow-sm">
                    {{ __('messages.apply_filters') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Bookings Table Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/50">
                        <th class="py-4 px-6 rounded-l-xl">{{ __('messages.column_service') }}</th>
                        <th class="py-4 px-6">{{ __('messages.column_customer') }}</th>
                        <th class="py-4 px-6">{{ __('messages.column_date') }}</th>
                        <th class="py-4 px-6">{{ __('messages.column_worker') }}</th>
                        <th class="py-4 px-6">{{ __('messages.column_status') }}</th>
                        <th class="py-4 px-6 rounded-r-xl text-right">{{ __('messages.column_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/50 transition">
                            <!-- Service Name -->
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ $booking->service->name }}
                            </td>
                            <!-- Customer Name -->
                            <td class="py-4 px-6 font-medium text-slate-700 text-xs">
                                {{ $booking->customer->name }}
                            </td>
                            <!-- Booking Date / Time Slot -->
                            @php
                                $slotKey = match($booking->preferred_time) {
                                    '09:00 AM - 11:00 AM' => 'slot_morning',
                                    '11:00 AM - 01:00 PM' => 'slot_late_morning',
                                    '02:00 PM - 04:00 PM' => 'slot_afternoon',
                                    '04:00 PM - 06:00 PM' => 'slot_evening',
                                    default => null
                                };
                            @endphp
                            <td class="py-4 px-6 font-semibold text-slate-500 text-xs">
                                <span class="block text-slate-800">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                                <span class="text-[10px] text-slate-400 font-bold block mt-0.5">
                                    {{ $slotKey ? __('messages.' . $slotKey) : $booking->preferred_time }}
                                </span>
                            </td>
                            <!-- Assigned Worker -->
                            <td class="py-4 px-6 text-xs text-slate-500 font-semibold">
                                {{ $booking->worker->name ?? __('messages.awaiting_assignment') }}
                            </td>
                            <!-- Status -->
                            <td class="py-4 px-6">
                                @if($booking->status === 'pending')
                                    <span class="px-2.5 py-0.5 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.pending') }}
                                    </span>
                                @elseif($booking->status === 'accepted')
                                    <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.accepted') }}
                                    </span>
                                @elseif($booking->status === 'completed')
                                    <span class="px-2.5 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.completed') }}
                                    </span>
                                @elseif($booking->status === 'rejected')
                                    <span class="px-2.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.rejected') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.cancelled') }}
                                    </span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-slate-450 hover:text-teal-655 font-extrabold text-xs transition">
                                    {{ __('messages.view_details') }} <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                                {{ __('messages.no_bookings_admin') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
