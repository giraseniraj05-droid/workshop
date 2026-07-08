<x-admin-layout>
    
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Add Worker</h2>
            <p class="text-slate-500 text-sm font-medium">Create a new service specialist account and profile.</p>
        </div>
        <a href="{{ route('admin.workers.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Workers
        </a>
    </div>

    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm max-w-4xl">
        <form method="POST" action="{{ route('admin.workers.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Authentication Credentials -->
            <div class="border-b border-slate-50 pb-6 mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-key text-blue-600 text-base"></i> Account Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="E.g. John Doe"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('name')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="E.g. john@example.com"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('email')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" id="password" required placeholder="Min 8 characters"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('password')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Worker Profile Information -->
            <div class="border-b border-slate-50 pb-6 mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-address-card text-blue-600 text-base"></i> Profile Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="E.g. +971 50 123 4567"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('phone')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Experience -->
                    <div>
                        <label for="experience" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Years of Experience</label>
                        <input type="number" name="experience" id="experience" value="{{ old('experience') }}" required min="0" placeholder="E.g. 5"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('experience')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Skills -->
                    <div>
                        <label for="skills" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Skills (Comma-separated)</label>
                        <input type="text" name="skills" id="skills" value="{{ old('skills') }}" required placeholder="Tiling, Grouting, Laying"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('skills')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required placeholder="Villa, Street, City"
                               class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                        @error('address')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Profile Photo -->
                    <div>
                        <label for="photo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Profile Photo</label>
                        <input type="file" name="photo" id="photo"
                               class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 file:hover:bg-blue-100 transition">
                        @error('photo')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Bio -->
                <div class="mb-6">
                    <label for="bio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Biography</label>
                    <textarea name="bio" id="bio" rows="3" required placeholder="Write a short summary introducing the worker to customers..."
                              class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 text-sm font-medium">{{ old('bio') }}</textarea>
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
                            <input type="url" name="linkedin" placeholder="https://linkedin.com/in/username" value="{{ old('linkedin') }}"
                                   class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-facebook text-blue-700 mr-1"></i> Facebook</label>
                            <input type="url" name="facebook" placeholder="https://facebook.com/username" value="{{ old('facebook') }}"
                                   class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram</label>
                            <input type="url" name="instagram" placeholder="https://instagram.com/username" value="{{ old('instagram') }}"
                                   class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Initial Service Assignments -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-600 text-base"></i> Service Assignments
                </h3>
                <p class="text-xs text-slate-400 mb-4">Choose which service categories this worker can perform immediately:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($services as $service)
                        <label class="flex items-center gap-3 p-4 border border-slate-100 rounded-xl hover:bg-slate-50 cursor-pointer transition">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="rounded text-blue-600 focus:ring-blue-200 h-4 w-4">
                            <span class="text-sm font-bold text-slate-700">{{ $service->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md">
                Add Worker Account
            </button>
        </form>
    </div>

</x-admin-layout>
