<x-admin-layout>
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Administrators</h2>
            <p class="text-slate-500 text-sm font-medium">Manage administrator accounts, roles, and security permissions.</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="px-5 py-3 bg-gradient-to-r from-slate-800 to-slate-950 text-white font-bold rounded-xl transition shadow-md">
            <i class="fa-solid fa-user-shield mr-1"></i> Add Admin
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
                        <th class="py-4 px-6 rounded-l-xl">Name</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Role</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 rounded-r-xl text-right">Actions</th>
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
                                        Super Admin
                                    </span>
                                @else
                                    <span class="text-slate-600 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-md">
                                        Admin
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($admin->status === 'active')
                                    <span class="px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="text-slate-400 hover:text-indigo-600 transition font-bold text-xs" title="Edit Permissions">
                                        <i class="fa-solid fa-user-shield text-base"></i>
                                    </a>
                                    
                                    @if($admin->id !== Auth::id())
                                        <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this admin account?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="Delete Admin">
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
