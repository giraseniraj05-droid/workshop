<x-admin-layout>
    
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Services</h2>
            <p class="text-slate-500 text-sm font-medium">Manage and define your marketplace service offerings.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="px-5 py-3 bg-gradient-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white font-bold rounded-xl transition shadow-md">
            <i class="fa-solid fa-plus mr-1"></i> Add Service
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Services Grid Card -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead>
                    <tr class="border-b border-slate-100 text-xs font-bold uppercase text-slate-400 bg-slate-50/50">
                        <th class="py-4 px-6 rounded-l-xl">Service</th>
                        <th class="py-4 px-6">Slug</th>
                        <th class="py-4 px-6">Base Price</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 rounded-r-xl text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($services as $service)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-semibold text-slate-800 flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-teal-55 text-teal-600 flex items-center justify-center border border-slate-100 flex-shrink-0 text-base shadow-sm">
                                    <i class="fa-solid fa-circle-notch text-slate-300"></i>
                                </div>
                                <div>
                                    <span class="block text-slate-800 font-extrabold text-sm">{{ $service->name }}</span>
                                    <span class="text-xs text-slate-400 font-semibold line-clamp-1 max-w-sm">{{ $service->description }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-xs font-semibold text-slate-500">
                                {{ $service->slug }}
                            </td>
                            <td class="py-4 px-6 font-extrabold text-slate-800 text-sm">
                                ${{ number_format($service->price, 2) }}
                            </td>
                            <td class="py-4 px-6">
                                @if($service->status === 'active')
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
                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="text-slate-400 hover:text-teal-600 transition font-bold text-xs">
                                        <i class="fa-solid fa-edit text-base"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-rose-600 transition">
                                            <i class="fa-solid fa-trash-can text-base"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium">
                                No services found. Click "Add Service" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
