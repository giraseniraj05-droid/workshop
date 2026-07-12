<x-admin-layout>
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">{{ __('messages.admin_enquiries_title') }}</h2>
            <p class="text-slate-500 text-sm font-medium">{{ __('messages.admin_enquiries_desc') }}</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm mb-8 max-w-sm">
        <form method="GET" action="{{ route('admin.enquiries.index') }}" class="flex items-end gap-4">
            <div class="flex-1">
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('messages.filter_status') }}</label>
                <select name="status" id="status" onchange="this.form.submit()"
                        class="w-full rounded-xl border-slate-200 focus:border-teal-500 text-slate-800 text-sm font-semibold">
                    <option value="">{{ __('messages.all_queries_option') }}</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>{{ __('messages.badge_open') }}</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>{{ __('messages.badge_resolved') }}</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Enquiries Table Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/50">
                        <th class="py-4 px-6 rounded-l-xl">{{ __('messages.col_customer') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_service_category') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_date_received') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_status') }}</th>
                        <th class="py-4 px-6 rounded-r-xl text-right">{{ __('messages.col_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($enquiries as $enquiry)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                <span class="block text-slate-800 font-extrabold text-sm">{{ $enquiry->customer_name }}</span>
                                <span class="text-xs text-slate-400 font-semibold block">{{ $enquiry->email }}</span>
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-600">
                                {{ $enquiry->service->name ?? __('messages.unassigned_label') }}
                            </td>
                            <td class="py-4 px-6 text-xs font-semibold text-slate-550">
                                {{ $enquiry->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($enquiry->status === 'open')
                                    <span class="px-2.5 py-0.5 bg-red-50 text-red-700 border border-red-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.badge_open') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.badge_resolved') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="text-slate-400 hover:text-teal-600 transition font-bold text-xs">
                                    {{ __('messages.col_reply') }} <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">
                                {{ __('messages.no_enquiries_admin') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
