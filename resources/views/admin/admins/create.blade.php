<x-admin-layout>
    
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Add Administrator</h2>
            <p class="text-slate-500 text-sm font-medium">Create a new system administrator with granular permissions.</p>
        </div>
        <a href="{{ route('admin.admins.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Admins
        </a>
    </div>

    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm max-w-3xl">
        <form method="POST" action="{{ route('admin.admins.store') }}" class="space-y-6">
            @csrf

            <!-- Credentials -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Jane Doe"
                           class="w-full rounded-xl border-slate-200 focus:border-slate-800 focus:ring focus:ring-slate-200 text-slate-800 font-medium">
                    @error('name')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="jane@example.com"
                           class="w-full rounded-xl border-slate-200 focus:border-slate-800 focus:ring focus:ring-slate-200 text-slate-800 font-medium">
                    @error('email')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" id="password" required placeholder="Min 8 characters"
                           class="w-full rounded-xl border-slate-200 focus:border-slate-800 focus:ring focus:ring-slate-200 text-slate-800 font-medium">
                    @error('password')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Role & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-50 pt-6">
                <!-- Role -->
                <div>
                    <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Admin Role</label>
                    <select name="role" id="role" required
                            class="w-full rounded-xl border-slate-200 focus:border-slate-800 focus:ring focus:ring-slate-200 text-slate-800 font-medium">
                        <option value="Admin">Standard Admin</option>
                        <option value="Super Admin">Super Admin (All Permissions)</option>
                    </select>
                    @error('role')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Account Status</label>
                    <select name="status" id="status" required
                            class="w-full rounded-xl border-slate-200 focus:border-slate-800 focus:ring focus:ring-slate-200 text-slate-800 font-medium">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive (Disabled)</option>
                    </select>
                    @error('status')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Permissions Module -->
            <div class="border-t border-slate-50 pt-6">
                <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider">Granular Security Permissions</h3>
                <p class="text-xs text-slate-400 mb-4">Select custom permissions to grant this administrator (only applies to Standard Admin role; Super Admins get all automatically):</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($permissions as $permission)
                        <label class="flex items-center gap-3 p-4 border border-slate-100 rounded-xl hover:bg-slate-50 cursor-pointer transition">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded text-slate-800 focus:ring-slate-200 h-4 w-4">
                            <div>
                                <span class="text-sm font-bold text-slate-700 block">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                <span class="text-[10px] text-slate-400 font-semibold block">Grant ability to perform actions related to: {{ str_replace('manage_', '', $permission->name) }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="px-6 py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition shadow-md">
                Create Admin Account
            </button>
        </form>
    </div>

</x-admin-layout>
