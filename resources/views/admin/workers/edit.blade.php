<x-admin-layout>
    
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Edit Worker Details</h2>
            <p class="text-slate-500 text-sm font-medium">Update account and profile details for: {{ $worker->name }}.</p>
        </div>
        <a href="{{ route('admin.workers.show', $worker->id) }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Details
        </a>
    </div>

    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm max-w-4xl">
        <form method="POST" action="{{ route('admin.workers.update', $worker->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Account Details -->
            <div class="border-b border-slate-50 pb-6 mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-key text-blue-600 text-base"></i> Account Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $worker->name) }}" required
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('name')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $worker->email) }}" required
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('email')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password (Optional) -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password (Optional)</label>
                        <input type="password" name="password" id="password" placeholder="Leave blank to keep current"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('password')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Profile Details -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-address-card text-blue-600 text-base"></i> Profile Details
                </h3>

                <!-- Status & Experience -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Worker Status</label>
                        <select name="status" id="status" required
                                class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                            <option value="active" {{ $worker->status === 'active' ? 'selected' : '' }}>Active (Available for Jobs)</option>
                            <option value="inactive" {{ $worker->status === 'inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
                        </select>
                        @error('status')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Experience -->
                    <div>
                        <label for="experience" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Years of Experience</label>
                        <input type="number" name="experience" id="experience" value="{{ old('experience', $profile->experience) }}" required min="0"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('experience')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Skills -->
                    <div>
                        <label for="skills" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Skills (Comma-separated)</label>
                        <input type="text" name="skills" id="skills" value="{{ old('skills', $skillsString) }}" required
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('skills')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Phone, Address, Photo -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}" required
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('phone')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $profile->address) }}" required
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('address')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Profile Photo -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Profile Photo</label>
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center flex-shrink-0">
                                @if($profile->photo)
                                    <img src="{{ asset('storage/' . $profile->photo) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <i class="fa-solid fa-user text-slate-350 text-xl"></i>
                                @endif
                            </div>
                            <input type="file" name="photo" id="photo"
                                   class="text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-blue-700 file:hover:bg-blue-100 transition">
                        </div>
                        @error('photo')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Biography -->
                <div class="mb-6">
                    <label for="bio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Biography</label>
                    <textarea name="bio" id="bio" rows="3" required
                              class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 text-sm font-medium">{{ old('bio', $profile->bio) }}</textarea>
                    @error('bio')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Socials -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-900">Social Profiles (URLs)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-linkedin text-blue-600 mr-1"></i> LinkedIn</label>
                            <input type="url" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}"
                                   class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-facebook text-blue-700 mr-1"></i> Facebook</label>
                            <input type="url" name="facebook" value="{{ old('facebook', $profile->facebook) }}"
                                   class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram</label>
                            <input type="url" name="instagram" value="{{ old('instagram', $profile->instagram) }}"
                                   class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md">
                Save Changes
            </button>
        </form>
    </div>

</x-admin-layout>
