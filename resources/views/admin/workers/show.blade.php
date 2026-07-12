<x-admin-layout>
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Worker Profile</h2>
            <p class="text-slate-500 text-sm font-medium">Trace assignments, logs, and profile details for: {{ $worker->name }}.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.workers.edit', $worker->id) }}" class="px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold rounded-lg transition text-sm">
                <i class="fa-solid fa-user-edit mr-1"></i> Edit Account
            </a>
            <a href="{{ route('admin.workers.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition text-sm">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Workers
            </a>
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Profile Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm text-center">
                <div class="h-28 w-28 rounded-full bg-slate-150 border-4 border-slate-50 mx-auto flex items-center justify-center font-bold text-slate-600 overflow-hidden shadow-inner text-3xl mb-4">
                    @if($profile->photo)
                        <img src="{{ asset('storage/' . $profile->photo) }}" class="w-full h-full object-cover" alt="">
                    @else
                        {{ substr($worker->name, 0, 2) }}
                    @endif
                </div>

                <h3 class="text-xl font-extrabold text-slate-900 mb-1">{{ $worker->name }}</h3>
                @if($reviewsCount > 0)
                    <div class="flex items-center justify-center gap-1 mt-1 mb-2 text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($averageRating))
                                <i class="fa-solid fa-star text-xs"></i>
                            @else
                                <i class="fa-regular fa-star text-xs"></i>
                            @endif
                        @endfor
                        <span class="text-slate-800 font-extrabold text-xs ml-1">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-slate-400 text-[10px]">({{ $reviewsCount }})</span>
                    </div>
                @endif
                <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full text-[10px] font-bold uppercase tracking-wider mb-4 inline-block">
                    {{ $worker->role }}
                </span>

                <div class="flex justify-center gap-4 text-xs font-semibold text-slate-500 mb-6">
                    <div>
                        <span class="block text-slate-800 text-lg font-black">{{ $profile->experience ?? 0 }}</span>
                        <span>Years Exp</span>
                    </div>
                    <span class="h-8 w-px bg-slate-100"></span>
                    <div>
                        <span class="block text-slate-800 text-lg font-black">
                            @if($worker->status === 'active')
                                <span class="text-teal-600">Active</span>
                            @else
                                <span class="text-rose-600">Inactive</span>
                            @endif
                        </span>
                        <span>Status</span>
                    </div>
                </div>

                <!-- Bio -->
                <p class="text-slate-500 text-xs leading-relaxed text-left border-t border-b border-slate-50 py-4 mb-6 italic">
                    "{{ $profile->bio ?? 'No biography provided yet.' }}"
                </p>

                <!-- Phone / Address -->
                <div class="text-left text-xs font-semibold text-slate-600 space-y-3">
                    <div><i class="fa-solid fa-phone text-slate-400 mr-2"></i> {{ $profile->phone ?? 'N/A' }}</div>
                    <div><i class="fa-solid fa-envelope text-slate-400 mr-2"></i> {{ $worker->email }}</div>
                    <div><i class="fa-solid fa-location-dot text-slate-400 mr-2 text-sm"></i> {{ $profile->address ?? 'N/A' }}</div>
                </div>

                <!-- Socials -->
                <div class="flex items-center justify-center gap-4 mt-6 border-t border-slate-50 pt-4">
                    @if($profile->linkedin)
                        <a href="{{ $profile->linkedin }}" target="_blank" class="h-8 w-8 rounded-full bg-slate-50 text-slate-400 hover:text-blue-600 border border-slate-100 flex items-center justify-center text-sm transition">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if($profile->facebook)
                        <a href="{{ $profile->facebook }}" target="_blank" class="h-8 w-8 rounded-full bg-slate-50 text-slate-400 hover:text-blue-700 border border-slate-100 flex items-center justify-center text-sm transition">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    @endif
                    @if($profile->instagram)
                        <a href="{{ $profile->instagram }}" target="_blank" class="h-8 w-8 rounded-full bg-slate-50 text-slate-400 hover:text-pink-650 border border-slate-100 flex items-center justify-center text-sm transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Skills Card -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h4 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider">Specialties & Skills</h4>
                <div class="flex flex-wrap gap-1.5">
                    @forelse(($profile->skills ?? []) as $skill)
                        <span class="px-3 py-1 bg-slate-50 border border-slate-100 text-slate-600 rounded-lg text-xs font-semibold">
                            {{ $skill }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-400 font-semibold italic">No skills listed.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Assignments & Logs -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Category Assignment Module -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-blue-600"></i> Active Service Assignments
                </h3>

                <!-- Active Assignments Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @forelse($assignedServices as $service)
                        <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-wrench"></i>
                                </div>
                                <span class="font-bold text-slate-800 text-sm">{{ $service->name }}</span>
                            </div>

                            <!-- Remove assignment form -->
                            <form method="POST" action="{{ route('admin.workers.remove', $worker->id) }}" onsubmit="return confirm('Remove worker from this service category?');">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <button type="submit" class="text-xs text-slate-400 hover:text-rose-600 transition font-bold">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-6 text-slate-400 font-medium italic">
                            No active service assignments found. Assign one below to make the worker visible publicly.
                        </div>
                    @endforelse
                </div>

                <!-- Add Assignment Form -->
                <form method="POST" action="{{ route('admin.workers.assign', $worker->id) }}" class="flex items-end gap-4 border-t border-slate-50 pt-6">
                    @csrf
                    <div class="flex-1">
                        <label for="service_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assign New Service Category</label>
                        <select name="service_id" id="service_id" required
                                class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 text-slate-800 font-medium">
                            <option value="" disabled selected>Select a Service</option>
                            @foreach($allServices as $service)
                                @if(!$assignedServices->contains('id', $service->id))
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-sm flex items-center gap-1">
                        <i class="fa-solid fa-plus"></i> Assign
                    </button>
                </form>
            </div>

            <!-- Historical Log Module -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-history text-blue-600"></i> Full Assignment Log History
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-500">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/50">
                                <th class="py-4 px-6 rounded-l-xl">Service Category</th>
                                <th class="py-4 px-6">Assigned At</th>
                                <th class="py-4 px-6">Assigned By</th>
                                <th class="py-4 px-6">Removed At</th>
                                <th class="py-4 px-6 rounded-r-xl">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-xs">
                            @forelse($history as $log)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-extrabold text-slate-800">
                                        {{ $log->service->name ?? 'Deleted Service' }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-slate-500">
                                        {{ $log->assigned_at ? $log->assigned_at->format('Y-m-d H:i') : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 font-medium">
                                        {{ $log->admin->name ?? 'System' }}
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-slate-400">
                                        {{ $log->removed_at ? $log->removed_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($log->status === 'active')
                                            <span class="px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-slate-50 text-slate-700 border border-slate-200 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                                Removed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 font-medium">
                                        No assignment history logged.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Worker Feedback & Reviews Module -->
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-star text-amber-500"></i> Worker Feedback & Reviews
                    @if($reviewsCount > 0)
                        <span class="text-slate-400 font-medium text-sm flex-shrink-0">({{ $reviewsCount }})</span>
                    @endif
                </h3>

                <div class="space-y-6">
                    @forelse($reviews as $review)
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold overflow-hidden flex-shrink-0">
                                        {{ substr($review->customer->name ?? 'User', 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">{{ $review->customer->name ?? 'Deleted User' }}</h4>
                                        <span class="text-xs text-slate-500">Service: <strong>{{ $review->service->name ?? 'Deleted Service' }}</strong></span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <div class="flex items-center gap-0.5 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fa-solid fa-star text-xs"></i>
                                            @else
                                                <i class="fa-regular fa-star text-xs"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                        {{ $review->created_at->format('Y-m-d') }}
                                    </span>
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-slate-650 text-sm italic bg-white p-3 rounded-xl border border-slate-50">"{{ $review->comment }}"</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 font-medium italic">
                            No reviews received for this worker yet.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</x-admin-layout>
