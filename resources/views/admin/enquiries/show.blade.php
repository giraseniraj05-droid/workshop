<x-admin-layout>
    
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Enquiry Detail</h2>
            <p class="text-slate-500 text-sm font-medium">Verify customer queries and submit replies.</p>
        </div>
        <a href="{{ route('admin.enquiries.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Enquiries
        </a>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-teal-50 border border-teal-200 text-teal-800 rounded-2xl p-4 mb-6 text-sm font-semibold flex items-start gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-teal-600 mt-0.5 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Side: Enquiry Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm space-y-6">
                
                <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                    <h3 class="text-xl font-bold text-slate-900">Enquiry regarding: {{ $enquiry->service->name ?? 'Service' }}</h3>
                    @if($enquiry->status === 'open')
                        <span class="px-3 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">
                            Open
                        </span>
                    @else
                        <span class="px-3 py-1 bg-teal-50 text-teal-700 border border-teal-200 rounded-full text-xs font-bold uppercase tracking-wider">
                            Resolved
                        </span>
                    @endif
                </div>

                <!-- Meta Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Customer Name</span>
                        <span class="font-extrabold text-slate-800 text-sm"><i class="fa-solid fa-user text-slate-350 mr-1.5 text-xs"></i> {{ $enquiry->customer_name }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Email Address</span>
                        <span class="font-extrabold text-slate-800 text-sm"><i class="fa-solid fa-envelope text-slate-350 mr-1.5 text-xs"></i> {{ $enquiry->email }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Phone Number</span>
                        <span class="font-extrabold text-slate-800 text-sm"><i class="fa-solid fa-phone text-slate-350 mr-1.5 text-xs"></i> {{ $enquiry->phone }}</span>
                    </div>
                </div>

                <!-- Message -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-2">Message Body</span>
                    <p class="text-slate-850 font-medium text-sm leading-relaxed">
                        "{{ $enquiry->message }}"
                    </p>
                </div>

                <!-- Saved Reply -->
                @if($enquiry->status === 'resolved')
                    <div class="bg-teal-50/50 rounded-2xl p-6 border border-teal-100/50">
                        <span class="block text-[10px] uppercase font-bold text-teal-600 tracking-wider mb-2">Admin Response (Replied at: {{ $enquiry->replied_at->format('Y-m-d H:i') }})</span>
                        <p class="text-teal-900 font-medium text-sm leading-relaxed">
                            "{{ $enquiry->admin_reply }}"
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side: Reply form -->
        <div class="lg:col-span-1 space-y-6">
            @if($enquiry->status === 'open')
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm h-fit">
                    <h3 class="text-lg font-bold text-slate-900 mb-6 border-b border-slate-50 pb-4">
                        <i class="fa-solid fa-paper-plane text-teal-600 mr-1"></i> Send Reply
                    </h3>

                    <form method="POST" action="{{ route('admin.enquiries.reply', $enquiry->id) }}" class="space-y-4">
                        @csrf

                        <!-- Reply Message -->
                        <div>
                            <label for="admin_reply" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Reply Message</label>
                            <textarea name="admin_reply" id="admin_reply" rows="6" required placeholder="Write your response message here..."
                                      class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 text-sm font-medium"></textarea>
                            @error('admin_reply')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition shadow-sm">
                            Submit & Mark Resolved
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </div>

</x-admin-layout>
