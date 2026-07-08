<x-admin-layout>
    
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-900 mb-1">Add Service</h2>
            <p class="text-slate-500 text-sm font-medium">Define a new category of home services in both English and Arabic.</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 hover:bg-slate-200 font-bold rounded-lg transition text-sm">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Services
        </a>
    </div>

    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm max-w-4xl">
        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section: Names -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name EN -->
                <div>
                    <label for="name_en" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Service Name (English)</label>
                    <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" required placeholder="E.g., Deep Cleaning"
                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                    @error('name_en')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Name AR -->
                <div dir="rtl">
                    <label for="name_ar" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 text-right">اسم الخدمة (العربية)</label>
                    <input type="text" name="name_ar" id="name_ar" value="{{ old('name_ar') }}" required placeholder="مثال: تنظيف عميق"
                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium text-right">
                    @error('name_ar')
                        <span class="text-xs text-red-600 mt-1 block text-right">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Parameters Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-slate-50 pt-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Starting Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required placeholder="E.g., 99.00"
                           class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                    @error('price')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Service Icon</label>
                    <select name="icon" id="icon" required
                            class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                        <option value="sparkles">Sparkles (Cleaning)</option>
                        <option value="grid">Grid (Tiling)</option>
                        <option value="paint-brush">Paint Brush (Painting)</option>
                        <option value="layer-group">Layer Group (Plastering)</option>
                        <option value="hammer">Hammer (Carpentry)</option>
                        <option value="droplet">Droplet (Plumbing)</option>
                        <option value="square">Square (False Ceiling)</option>
                        <option value="cog">Cog (General Glass/Aluminium)</option>
                    </select>
                    @error('icon')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Initial Status</label>
                    <select name="status" id="status" required
                            class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 font-medium">
                        <option value="active">Active (Visible Publicly)</option>
                        <option value="inactive">Inactive (Hidden Publicly)</option>
                    </select>
                    @error('status')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Descriptions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-50 pt-6">
                <!-- Description EN -->
                <div>
                    <label for="description_en" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Description (English)</label>
                    <textarea name="description_en" id="description_en" rows="4" required placeholder="Write English description..."
                              class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 text-sm font-medium">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description AR -->
                <div dir="rtl">
                    <label for="description_ar" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 text-right">الوصف (العربية)</label>
                    <textarea name="description_ar" id="description_ar" rows="4" required placeholder="اكتب الوصف بالعربية..."
                              class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring focus:ring-teal-200 text-slate-800 text-sm font-medium text-right">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <span class="text-xs text-red-600 mt-1 block text-right">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Hero Image -->
            <div class="border-t border-slate-50 pt-6">
                <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hero Image</label>
                <input type="file" name="image" id="image" required
                       class="text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 file:hover:bg-teal-100 transition">
                <span class="text-[10px] text-slate-400 block mt-1">Accepts JPG, PNG up to 2MB.</span>
                @error('image')
                    <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition shadow-md">
                Create Service
            </button>
        </form>
    </div>

</x-admin-layout>
