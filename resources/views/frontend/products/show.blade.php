@extends('layouts.app')

@section('title', $product->name . ' - Petchemparts')

@section('content')

<!-- Breadcrumb -->
<div class="bg-slate-100 border-b border-slate-200 py-3 px-4 text-xs text-slate-600">
    <div class="max-w-7xl mx-auto flex items-center space-x-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-sky-600">Products</a>
        @if($product->category)
            <span>/</span>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-sky-600">{{ $product->category->name }}</a>
        @endif
        @if($product->subCategory)
            <span>/</span>
            <a href="{{ route('products.index', ['category' => $product->category->slug ?? '', 'subcategory' => $product->subCategory->slug]) }}" class="hover:text-sky-600">{{ $product->subCategory->name }}</a>
        @endif
        <span>/</span>
        <span class="text-slate-900 font-semibold truncate max-w-xs">{{ $product->name }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            
            <!-- Left Column: Multi-Image Gallery -->
            <div>
                @php 
                    $images = $product->images ?? [];
                    $mainImage = (!empty($images) && isset($images[0])) ? asset($images[0]) : asset('images/newlogo.jpeg');
                @endphp
                
                <div class="border rounded-2xl bg-slate-50 overflow-hidden h-96 flex items-center justify-center p-4 mb-4 border-slate-200">
                    <img id="main-product-image" src="{{ $mainImage }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain transition">
                </div>

                @if(count($images) > 1)
                    <div class="flex gap-3 overflow-x-auto pb-2">
                        @foreach($images as $index => $img)
                            <button type="button" onclick="changeMainImage('{{ asset($img) }}')" class="w-16 h-16 border-2 rounded-lg bg-slate-50 p-1 flex-shrink-0 hover:border-sky-500 focus:border-sky-600 transition">
                                <img src="{{ asset($img) }}" alt="Thumbnail {{ $index+1 }}" class="w-full h-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Product Specs & Quote Action -->
            <div class="flex flex-col justify-between">
                <div>
                    <!-- Taxonomy & Manufacturer Badges -->
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @if($product->manufacturer)
                            <span class="bg-sky-100 text-sky-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $product->manufacturer->name }}
                            </span>
                        @endif

                        @if($product->category)
                            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-3 py-1 rounded-full border border-slate-200 transition">
                                <i class="fa-solid fa-folder text-[10px] text-slate-400 mr-1"></i> {{ $product->category->name }}
                            </a>
                        @endif

                        @if($product->subCategory)
                            <a href="{{ route('products.index', ['category' => $product->category->slug ?? '', 'subcategory' => $product->subCategory->slug]) }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full border border-emerald-200 transition">
                                <i class="fa-solid fa-folder-tree text-[10px] text-emerald-500 mr-1"></i> {{ $product->subCategory->name }}
                            </a>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- Key Technical Metadata Cards Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Part Number</span>
                            <span class="font-mono font-bold text-slate-800 text-xs sm:text-sm truncate block">{{ $product->part_number }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Model Number</span>
                            <span class="font-mono font-bold text-slate-800 text-xs sm:text-sm truncate block">{{ $product->model_number }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Category</span>
                            <span class="font-bold text-slate-800 text-xs sm:text-sm truncate block">{{ $product->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Sub-Category</span>
                            <span class="font-bold text-slate-800 text-xs sm:text-sm truncate block">{{ $product->subCategory->name ?? 'None' }}</span>
                        </div>
                    </div>

                    <!-- Short Summary -->
                    @if($product->summary)
                        <div class="text-sm text-slate-600 mb-6 leading-relaxed bg-sky-50/50 p-4 rounded-xl border border-sky-100">
                            <h4 class="font-bold text-xs uppercase text-sky-900 mb-1">Product Specification</h4>
                            {{ $product->summary }}
                        </div>
                    @endif

                    <!-- Stock & Price Box -->
                    <div class="flex items-baseline gap-4 mb-6 border-y border-slate-100 py-4">
                        <div>
                            <span class="text-xs text-slate-400 block font-medium">Petchemparts Unit Price:</span>
                            <span class="text-3xl font-extrabold text-sky-900">£{{ number_format($product->price, 2) }}</span>
                        </div>

                        <div class="ml-auto text-right">
                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full border border-emerald-200">
                                <i class="fa-solid fa-circle-check text-[10px]"></i> In Stock ({{ $product->quantity }} available)
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <!-- Conditional PDF Download Link/Button (Shown ONLY if PDF selected by Admin) -->
                    @if($product->pdf && file_exists(public_path($product->pdf->file_path)))
                        <div class="mb-6">
                            <a href="{{ asset($product->pdf->file_path) }}" target="_blank" class="w-full bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition">
                                <i class="fa-solid fa-file-pdf text-rose-600 text-lg"></i>
                                <span>Download Datasheet PDF ({{ $product->pdf->title }})</span>
                                <i class="fa-solid fa-download ml-auto text-xs"></i>
                            </a>
                        </div>
                    @endif

                    <!-- Add to Request System Action -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="inline-flex items-center border rounded-xl border-slate-300 bg-slate-50 overflow-hidden sm:w-36 justify-between p-1">
                            <button type="button" onclick="adjustProductQty(-1)" class="w-10 h-10 bg-white hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">-</button>
                            <input type="number" id="detail-qty-input" value="1" min="1" class="w-12 text-center bg-transparent font-bold text-sm focus:outline-none">
                            <button type="button" onclick="adjustProductQty(1)" class="w-10 h-10 bg-white hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">+</button>
                        </div>

                        <button id="detail-add-request-btn" onclick="addCurrentProductToRequest()" class="flex-grow bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-sm py-3.5 px-6 rounded-xl shadow-lg shadow-sky-200 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-plus text-base"></i>
                            <span> Request For  quote</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Detailed Description Section -->
        @if($product->description)
            <div class="mt-12 border-t border-slate-200 pt-8">
                <h3 class="font-bold text-lg text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-file-lines text-sky-600"></i> Detailed Specifications & Description
                </h3>
                <div class="prose max-w-none text-slate-600 text-sm leading-relaxed whitespace-pre-line bg-slate-50 p-6 rounded-2xl border border-slate-200">
                    {{ $product->description }}
                </div>
            </div>
        @endif
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h3 class="font-bold text-xl text-slate-900 mb-6">Related Products in Category</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    @php 
                        $relImg = (!empty($rel->images) && isset($rel->images[0])) ? asset($rel->images[0]) : asset('images/newlogo.jpeg');
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition p-4">
                        <div class="h-36 w-full bg-slate-50 rounded-xl overflow-hidden mb-3 border border-slate-100 flex items-center justify-center">
                            <img src="{{ $relImg }}" alt="{{ $rel->name }}" class="h-full w-full object-contain p-2">
                        </div>
                        <h4 class="font-bold text-xs text-slate-900 line-clamp-2 hover:text-sky-600 mb-1">
                            <a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a>
                        </h4>
                        <div class="text-[11px] font-bold text-sky-900 mb-3">£{{ number_format($rel->price, 2) }}</div>
                        <a href="{{ route('products.show', $rel->slug) }}" class="block text-center w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold py-1.5 rounded-lg transition">
                            View Product
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function changeMainImage(src) {
        document.getElementById('main-product-image').src = src;
    }

    function adjustProductQty(delta) {
        const input = document.getElementById('detail-qty-input');
        let current = parseInt(input.value) || 1;
        current += delta;
        if (current < 1) current = 1;
        input.value = current;
    }

    function addCurrentProductToRequest() {
        const qty = parseInt(document.getElementById('detail-qty-input').value) || 1;
        const productId = {{ $product->id }};
        const name = "{{ addslashes($product->name) }}";
        const partNumber = "{{ addslashes($product->part_number) }}";
        const price = {{ $product->price }};
        const image = "{{ (!empty($images) && isset($images[0])) ? $images[0] : 'images/newlogo.jpeg' }}";

        let items = getRequestItems();
        let existing = items.find(i => i.product_id === productId);

        if (existing) {
            existing.quantity += qty;
        } else {
            items.push({
                product_id: productId,
                name: name,
                part_number: partNumber,
                price: price,
                image: image,
                quantity: qty
            });
        }

        saveRequestItems(items);
        showToast(`Product successfully added to your request list!`, 'success');

        const btn = document.getElementById('detail-add-request-btn');
        if (btn) {
            btn.className = btn.className.replace('bg-[var(--primary-dark)] hover:bg-sky-700', 'bg-emerald-600 hover:bg-emerald-700');
            btn.innerHTML = `<i class="fa-solid fa-check text-base"></i> <span>Added to Request for quote</span>`;
            setTimeout(() => {
                btn.className = btn.className.replace('bg-emerald-600 hover:bg-emerald-700', 'bg-[var(--primary-dark)] hover:bg-sky-700');
                btn.innerHTML = `<i class="fa-solid fa-plus text-base"></i> <span> Request For  quote</span>`;
            }, 3000);
        }
    }
</script>
@endpush

@endsection
