<x-admin-layout>
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">{{ __('messages.admin_workers_title') }}</h2>
            <p class="text-slate-500 text-sm font-medium">{{ __('messages.admin_workers_desc') }}</p>
        </div>
        <a href="{{ route('admin.workers.create') }}" class="px-5 py-2.5 bg-teal-500 hover:bg-teal-600 text-white font-bold rounded-lg text-xs shadow-sm transition">
            <i class="fa-solid fa-plus mr-1"></i> {{ __('messages.add_specialist_btn') }}
        </a>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Workers Table -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/50">
                        <th class="py-4 px-6 rounded-l-xl">{{ __('messages.col_name') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_email') }}</th>
                        <th class="py-4 px-6">{{ __('messages.phone') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_status') }}</th>
                        <th class="py-4 px-6 rounded-r-xl text-right">{{ __('messages.col_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($workers as $worker)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-slate-800 flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-650 overflow-hidden shadow-inner text-sm flex-shrink-0">
                                    @if($worker->workerProfile && $worker->workerProfile->photo)
                                        <img src="{{ asset('storage/' . $worker->workerProfile->photo) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        {{ substr($worker->name, 0, 2) }}
                                    @endif
                                </div>
                                <div>
                                    <span class="block text-sm text-slate-800">{{ $worker->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                                        {{ $worker->workerProfile->experience ?? 0 }} {{ __('messages.yrs_exp') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium text-xs">
                                {{ $worker->email }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium text-xs">
                                {{ $worker->workerProfile->phone ?? __('messages.na_label') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($worker->status === 'active')
                                    <span class="px-2.5 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.badge_active') }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                        {{ __('messages.badge_inactive') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.workers.show', $worker->id) }}" class="text-slate-450 hover:text-teal-655 font-extrabold text-xs transition">
                                    {{ __('messages.manage_btn') }} <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">
                                {{ __('messages.no_specialists_admin') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
