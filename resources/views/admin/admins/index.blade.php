<x-admin-layout>
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">{{ __('messages.admin_admins_title') }}</h2>
            <p class="text-slate-500 text-sm font-medium">{{ __('messages.admin_admins_desc') }}</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="px-5 py-3 bg-gradient-to-r from-slate-800 to-slate-950 text-white font-bold rounded-xl transition shadow-md">
            <i class="fa-solid fa-user-shield mr-1"></i> {{ __('messages.add_admin_btn') }}
        </a>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Admins Table Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/50">
                        <th class="py-4 px-6 rounded-l-xl">{{ __('messages.col_name') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_email') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_role') }}</th>
                        <th class="py-4 px-6">{{ __('messages.col_status') }}</th>
                        <th class="py-4 px-6 rounded-r-xl text-right">{{ __('messages.col_actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($admins as $admin)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-slate-800 flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 overflow-hidden shadow-inner text-xs">
                                    {{ substr($admin->name, 0, 2) }}
                                </div>
                                {{ $admin->name }}
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-600">
                                {{ $admin->email }}
                            </td>
                            <td class="py-4 px-6 text-xs font-bold">
                                @if($admin->role === 'Super Admin')
                                    <span class="text-indigo-650 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded-md">
                                        {{ __('messages.super_admin_label') }}
                                    </span>
                                @else
                                    <span class="text-slate-600 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-md">
                                        {{ __('messages.admin_label') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($admin->status === 'active')
                                    <span class="px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('messages.badge_active') }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ __('messages.badge_inactive') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="text-slate-400 hover:text-indigo-600 transition font-bold text-xs" title="{{ __('messages.admin_admins_title') }}">
                                        <i class="fa-solid fa-user-shield text-base"></i>
                                    </a>
                                    
                                    @if($admin->id !== Auth::id())
                                        <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete_admin') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="{{ __('messages.confirm_delete_admin') }}">
                                                <i class="fa-solid fa-trash-can text-base"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
