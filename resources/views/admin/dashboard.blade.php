<x-admin-layout>
    
    <!-- Top Greeting Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">{{ __('messages.dashboard') }}</h2>
            <p class="text-slate-500 text-sm font-medium">{{ __('messages.admin_dashboard_desc') }}</p>
        </div>
    </div>

    <!-- Stat Widgets Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-5 gap-8 mb-10">
        
        <!-- Services -->
        <div class="w-full h-full min-h-[150px] bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="h-14 w-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div class="min-w-0 flex-1 flex flex-col justify-center">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-[0.18em] block leading-tight">{{ __('messages.total_services') }}</span>
                <div class="mt-2 inline-flex items-end gap-1 whitespace-nowrap">
                    <span class="text-3xl font-black text-slate-800 leading-none">{{ $stats['active_services'] }}</span>
                    <span class="text-xs text-slate-400 font-normal leading-none">/ {{ $stats['total_services'] }}</span>
                </div>
            </div>
        </div>

        <!-- Workers -->
        <div class="w-full h-full min-h-[150px] bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-user-gear"></i>
            </div>
            <div class="min-w-0 flex-1 flex flex-col justify-center">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-[0.18em] block leading-tight">{{ __('messages.total_workers') }}</span>
                <div class="mt-2 inline-flex items-end gap-1 whitespace-nowrap">
                    <span class="text-3xl font-black text-slate-800 leading-none">{{ $stats['active_workers'] }}</span>
                    <span class="text-xs text-slate-400 font-normal leading-none">/ {{ $stats['total_workers'] }}</span>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="w-full h-full min-h-[150px] bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="h-14 w-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="min-w-0 flex-1 flex flex-col justify-center">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-[0.18em] block leading-tight">{{ __('messages.total_customers') }}</span>
                <span class="mt-2 text-3xl font-black text-slate-800 leading-none whitespace-nowrap">{{ $stats['total_customers'] }}</span>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="w-full h-full min-h-[150px] bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="h-14 w-14 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center flex-shrink-0 text-lg relative">
                <i class="fa-solid fa-calendar-check"></i>
                @if($stats['pending_bookings'] > 0)
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-yellow-500 ring-2 ring-white"></span>
                @endif
            </div>
            <div class="min-w-0 flex-1 flex flex-col justify-center">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-[0.18em] block leading-tight">{{ __('messages.pending_jobs') }}</span>
                <span class="mt-2 text-3xl font-black text-slate-800 leading-none whitespace-nowrap">{{ $stats['pending_bookings'] }}</span>
            </div>
        </div>

        <!-- Open Enquiries -->
        <div class="w-full h-full min-h-[150px] bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="h-14 w-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0 text-lg relative">
                <i class="fa-solid fa-envelope-open-text"></i>
                @if($stats['open_enquiries'] > 0)
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                @endif
            </div>
            <div class="min-w-0 flex-1 flex flex-col justify-center">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-[0.18em] block leading-tight">{{ __('messages.open_queries') }}</span>
                <span class="mt-2 text-3xl font-black text-slate-800 leading-none whitespace-nowrap">{{ $stats['open_enquiries'] }}</span>
            </div>
        </div>

    </div>

    <!-- Recent Assignments Table Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-clipboard-user text-teal-600"></i> {{ __('messages.recent_worker_assignments') }}
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/50">
                        <th class="py-4 px-6 rounded-l-xl">{{ __('messages.column_worker') }}</th>
                        <th class="py-4 px-6">{{ __('messages.column_service') }}</th>
                        <th class="py-4 px-6">{{ __('messages.assigned_by') }}</th>
                        <th class="py-4 px-6">{{ __('messages.date_assigned') }}</th>
                        <th class="py-4 px-6 rounded-r-xl">{{ __('messages.column_status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentAssignments as $assignment)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-slate-800 flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 overflow-hidden shadow-inner text-xs">
                                    @if($assignment->worker->workerProfile && $assignment->worker->workerProfile->photo)
                                        <img src="{{ asset('storage/' . $assignment->worker->workerProfile->photo) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        {{ substr($assignment->worker->name, 0, 2) }}
                                    @endif
                                </div>
                                {{ $assignment->worker->name }}
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-600">
                                {{ $assignment->service->name }}
                            </td>
                            <td class="py-4 px-6 text-xs font-medium text-slate-500">
                                {{ $assignment->admin->name ?? __('messages.system_label') }}
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-500 font-semibold">
                                {{ $assignment->assigned_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($assignment->status === 'active')
                                    <span class="px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('messages.active') }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('messages.inactive') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">
                                {{ __('messages.no_recent_worker_assignments') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
