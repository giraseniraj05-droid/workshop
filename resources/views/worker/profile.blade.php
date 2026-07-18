<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-user-cog text-blue-600"></i> {{ __('Edit Worker Profile') }}
            </span>
            <a href="{{ route('worker.dashboard') }}" class="px-4 py-2 text-sm bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition btn-press">
                <i class="fa-solid fa-arrow-left mr-1"></i> {{ __('messages.back_to_dashboard') }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Success Messages -->
            @if(session('success'))
                <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 text-sm font-semibold flex items-start gap-2 shadow-sm">
                    <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Profile Edit Form -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover-card-lift">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 border-b border-slate-50 pb-4">
                        <i class="fa-solid fa-address-card text-blue-600 mr-1"></i> {{ __('Profile Details') }}
                    </h3>

                    <form method="POST" action="{{ route('worker.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Photo -->
                        <div class="flex items-center gap-6">
                            <div class="h-20 w-20 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-600 font-bold overflow-hidden shadow-inner flex-shrink-0">
                                @if($profile->photo)
                                    <img src="{{ asset('storage/' . $profile->photo) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <i class="fa-solid fa-user-circle text-4xl text-slate-300"></i>
                                @endif
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('Profile Photo') }}</label>
                                <input type="file" name="photo" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 file:hover:bg-blue-100 transition">
                                <span class="text-[10px] text-slate-400 block mt-1">{{ __('Accepts JPG, PNG up to 2MB.') }}</span>
                                @error('photo')
                                    <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name (Read-Only) -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Full Name (Read-Only)') }}</label>
                                <input type="text" disabled value="{{ $user->name }}" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-400 font-medium">
                            </div>
                            
                            <!-- Email (Read-Only) -->
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">{{ __('Email (Read-Only)') }}</label>
                                <input type="email" disabled value="{{ $user->email }}" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-400 font-medium">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}" required
                                       class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium input-focus-glow">
                                @error('phone')
                                    <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Skills (Comma Separated) -->
                            <div>
                                <label for="skills" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('Skills (Comma-separated)') }}</label>
                                <input type="text" name="skills" id="skills" value="{{ old('skills', $skillsString) }}" required placeholder="{{ __('E.g. Tiling, Grouting, Marble repair') }}"
                                       class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium input-focus-glow">
                                @error('skills')
                                    <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('Address') }}</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $profile->address) }}" required
                                   class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                            @error('address')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('Professional Biography') }}</label>
                            <textarea name="bio" id="bio" rows="4" required
                                      class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 text-sm font-medium">{{ old('bio', $profile->bio) }}</textarea>
                            @error('bio')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Social Links -->
                        <div class="border-t border-slate-50 pt-6 space-y-4">
                            <h4 class="text-sm font-bold text-slate-900 mb-2">{{ __('Social Profiles (URLs)') }}</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Linkedin -->
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-linkedin text-blue-600 mr-1"></i> {{ __('LinkedIn') }}</label>
                                    <input type="url" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}"
                                           class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                                    @error('linkedin')
                                        <span class="text-[10px] text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Facebook -->
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-facebook text-blue-700 mr-1"></i> {{ __('Facebook') }}</label>
                                    <input type="url" name="facebook" value="{{ old('facebook', $profile->facebook) }}"
                                           class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                                    @error('facebook')
                                        <span class="text-[10px] text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Instagram -->
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1"><i class="fa-brands fa-instagram text-pink-600 mr-1"></i> {{ __('Instagram') }}</label>
                                    <input type="url" name="instagram" value="{{ old('instagram', $profile->instagram) }}"
                                           class="w-full rounded-lg border-slate-200 text-xs font-medium focus:border-blue-500 focus:ring-0">
                                    @error('instagram')
                                        <span class="text-[10px] text-red-600 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-md">
                            {{ __('Save Changes') }}
                        </button>
                    </form>
                </div>

                <!-- Right: Password Change Card -->
                <div class="lg:col-span-1 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm h-fit">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 border-b border-slate-50 pb-4">
                        <i class="fa-solid fa-lock text-blue-600 mr-1"></i> {{ __('Change Password') }}
                    </h3>

                    <form method="POST" action="{{ route('worker.profile.password') }}" class="space-y-4">
                        @csrf

                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('Current Password') }}</label>
                            <input type="password" name="current_password" id="current_password" required
                                   class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('current_password')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('New Password') }}</label>
                            <input type="password" name="password" id="password" required
                                   class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            @error('password')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('Confirm New Password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>

                        <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition">
                            {{ __('Update Password') }}
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
