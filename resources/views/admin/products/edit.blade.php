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

        <!-- Row 6: Product Images Management -->
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2">Existing Product Images</label>
                @if(!empty($product->images) && count($product->images) > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-2" id="existing-images-grid">
                        @foreach($product->images as $index => $img)
                            <div class="relative group border rounded-xl bg-white p-2 text-center shadow-sm" id="image-card-{{ $index }}">
                                @if($index === 0)
                                    <span class="absolute top-1 left-1 bg-sky-600 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded shadow z-10">MAIN</span>
                                @endif
                                <button type="button" onclick="deleteProductImage({{ $product->id }}, {{ $index }}, '{{ addslashes($img) }}')" 
                                        class="absolute top-1 right-1 bg-rose-500 hover:bg-rose-700 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center shadow transition z-10"
                                        title="Delete this image">
                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                </button>
                                <div class="w-full h-20 flex items-center justify-center overflow-hidden mb-1">
                                    <img src="{{ asset($img) }}" alt="Product Image {{ $index + 1 }}" class="max-h-full max-w-full object-contain">
                                </div>
                                <label class="inline-flex items-center text-[10px] text-slate-600 font-medium cursor-pointer">
                                    <input type="checkbox" name="remove_images[]" value="{{ $index }}" class="rounded text-rose-600 focus:ring-rose-500 mr-1">
                                    Remove
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-500 italic mb-2">No images uploaded for this product yet.</p>
                @endif
            </div>

            <div class="pt-3 border-t border-slate-200">
                <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1">Upload New Images</label>
                <input type="file" name="images[]" multiple accept="image/*" class="w-full text-xs border rounded-lg border-slate-300 p-2 bg-white mb-3">

                <div class="flex flex-col sm:flex-row gap-4">
                    <label class="inline-flex items-center text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="set_primary" value="1" checked class="rounded text-sky-600 focus:ring-sky-500 mr-2">
                        Set newly uploaded image as Main/Primary display image
                    </label>

                    <label class="inline-flex items-center text-xs font-semibold text-rose-700 cursor-pointer">
                        <input type="checkbox" name="replace_existing" value="1" class="rounded text-rose-600 focus:ring-rose-500 mr-2">
                        Replace ALL existing images with new upload(s)
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded text-sky-600 focus:ring-sky-500 mr-2">
            <label for="is_active" class="text-xs font-semibold text-slate-700">Display / Active on Frontend Catalog</label>
        </div>

        <div class="pt-4 border-t flex gap-3">
            <button type="submit" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition">Update Product</button>
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

    async function deleteProductImage(productId, index, imagePath) {
        if (!confirm('Are you sure you want to delete this image?')) return;

        try {
            const token = document.querySelector('input[name="_token"]')?.value;
            
            const response = await fetch(`/admin/products/${productId}/delete-image`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    image_index: index,
                    image_path: imagePath
                })
            });

            const result = await response.json();
            if (result.success) {
                const card = document.getElementById(`image-card-${index}`);
                if (card) card.remove();
            } else {
                alert(result.message || 'Failed to delete image.');
            }
        } catch (e) {
            console.error(e);
            alert('An error occurred while deleting the image.');
        }
    }
</script>
@endpush

@endsection
