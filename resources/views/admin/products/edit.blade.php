@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <h3 class="text-lg font-bold text-slate-900 mb-6">Edit Product: {{ $product->name }}</h3>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Row 1: Manufacturer & Category & Subcategory -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Manufacturer <span class="text-rose-500">*</span></label>
                <select name="manufacturer_id" required class="w-full text-xs p-2.5 border rounded-lg border-slate-300 bg-white focus:ring-2 focus:ring-sky-500">
                    <option value="">-- Select Manufacturer --</option>
                    @foreach($manufacturers as $manuf)
                        <option value="{{ $manuf->id }}" {{ $product->manufacturer_id == $manuf->id ? 'selected' : '' }}>{{ $manuf->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Category <span class="text-rose-500">*</span></label>
                <select name="category_id" id="category_select" onchange="loadSubcategories(this.value)" required class="w-full text-xs p-2.5 border rounded-lg border-slate-300 bg-white focus:ring-2 focus:ring-sky-500">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Sub-Category (Optional)</label>
                <select name="sub_category_id" id="subcategory_select" class="w-full text-xs p-2.5 border rounded-lg border-slate-300 bg-white focus:ring-2 focus:ring-sky-500">
                    <option value="">-- Select Sub-category --</option>
                    @foreach($subcategories as $sub)
                        <option value="{{ $sub->id }}" {{ $product->sub_category_id == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Row 2: Product Name -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Product Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
        </div>

        <!-- Row 3: Part #, Model #, Quantity, Price £ -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Part Number <span class="text-rose-500">*</span></label>
                <input type="text" name="part_number" value="{{ old('part_number', $product->part_number) }}" required class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 font-mono">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Model Number <span class="text-rose-500">*</span></label>
                <input type="text" name="model_number" value="{{ old('model_number', $product->model_number) }}" required class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 font-mono">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Stock Quantity <span class="text-rose-500">*</span></label>
                <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 font-bold">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Price (£ GBP) <span class="text-rose-500">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" min="0" required class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 font-bold text-sky-900">
            </div>
        </div>

        <!-- Row 4: PDF Document Selection (OPTIONAL) -->
        <div class="bg-sky-50/70 p-4 rounded-xl border border-sky-100">
            <label class="block text-xs font-bold text-sky-900 uppercase tracking-wider mb-1">
                <i class="fa-solid fa-file-pdf text-rose-600 mr-1"></i> Technical PDF Datasheet (Optional)
            </label>
            <select name="pdf_id" class="w-full text-xs p-2.5 border rounded-lg border-slate-300 bg-white focus:ring-2 focus:ring-sky-500">
                <option value="">-- None (No Download Button on Product Page) --</option>
                @foreach($pdfs as $pdf)
                    <option value="{{ $pdf->id }}" {{ $product->pdf_id == $pdf->id ? 'selected' : '' }}>
                        {{ $pdf->title }} ({{ $pdf->file_path }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Row 5: Summary & Detailed Description -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Short Summary</label>
            <textarea name="summary" rows="2" class="w-full text-xs p-3 border rounded-lg border-slate-300">{{ old('summary', $product->summary) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Detailed Specification & Description</label>
            <textarea name="description" rows="5" class="w-full text-xs p-3 border rounded-lg border-slate-300">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Row 6: Multiple Images -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Existing Product Images</label>
            @if(!empty($product->images))
                <div class="flex gap-3 mb-3">
                    @foreach($product->images as $img)
                        <div class="w-16 h-16 border rounded-lg bg-slate-50 p-1">
                            <img src="{{ asset($img) }}" alt="Product Image" class="w-full h-full object-contain">
                        </div>
                    @endforeach
                </div>
            @endif

            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Upload Additional Images</label>
            <input type="file" name="images[]" multiple accept="image/*" class="w-full text-xs border rounded-lg border-slate-300 p-2 bg-slate-50">
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded text-sky-600 focus:ring-sky-500 mr-2">
            <label for="is_active" class="text-xs font-semibold text-slate-700">Display / Active on Frontend Catalog</label>
        </div>

        <div class="pt-4 border-t flex gap-3">
            <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    async function loadSubcategories(categoryId) {
        const select = document.getElementById('subcategory_select');
        select.innerHTML = '<option value="">Loading subcategories...</option>';
        if (!categoryId) {
            select.innerHTML = '<option value="">-- Select Category First --</option>';
            return;
        }

        try {
            const response = await fetch(`/admin/ajax/subcategories/${categoryId}`);
            const data = await response.json();
            
            let options = '<option value="">-- Select Sub-category (Optional) --</option>';
            data.forEach(sub => {
                options += `<option value="${sub.id}">${sub.name}</option>`;
            });
            select.innerHTML = options;
        } catch (e) {
            select.innerHTML = '<option value="">-- None Available --</option>';
        }
    }
</script>
@endpush

@endsection
