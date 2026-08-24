@extends('layouts.admin')

@section('title', 'Manage Products Catalog')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Products Catalog</h3>
        <p class="text-xs text-slate-500">Manage technical product specifications, pricing, multiple images, and attached PDFs.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i>
        <span>Add Product</span>
    </a>
</div>

<!-- Filters Bar -->
<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Name, Part #, Model #..." class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300">
        </div>

        <div>
            <select name="category_id" class="w-full text-xs p-2 border rounded-lg border-slate-300 bg-white">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select name="manufacturer_id" class="w-full text-xs p-2 border rounded-lg border-slate-300 bg-white">
                <option value="">All Manufacturers</option>
                @foreach($manufacturers as $manuf)
                    <option value="{{ $manuf->id }}" {{ request('manufacturer_id') == $manuf->id ? 'selected' : '' }}>{{ $manuf->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-grow bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs py-2 rounded-lg transition">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs px-3 py-2 rounded-lg font-semibold flex items-center justify-center">Reset</a>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Product</th>
                <th class="p-4">Part / Model #</th>
                <th class="p-4">Brand / Category</th>
                <th class="p-4">Price (£)</th>
                <th class="p-4">Stock Qty</th>
                <th class="p-4">PDF Attached</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($products as $prod)
                @php $img = (!empty($prod->images) && isset($prod->images[0])) ? asset($prod->images[0]) : asset('images/logo.png'); @endphp
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $img }}" alt="{{ $prod->name }}" class="w-10 h-10 object-contain rounded border bg-white p-1">
                            <div>
                                <a href="{{ route('products.show', $prod->slug) }}" target="_blank" class="font-bold text-slate-900 text-sm hover:text-sky-600 line-clamp-1 max-w-[200px]">
                                    {{ $prod->name }}
                                </a>
                                <span class="text-[10px] text-slate-400">ID: #{{ $prod->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 font-mono">
                        <div><strong class="text-slate-700">Part:</strong> {{ $prod->part_number }}</div>
                        <div class="text-[11px] text-slate-500"><strong>Model:</strong> {{ $prod->model_number }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $prod->manufacturer->name ?? 'N/A' }}</div>
                        <div class="text-[11px] text-sky-700">{{ $prod->category->name ?? 'N/A' }}</div>
                    </td>
                    <td class="p-4 font-bold text-sky-900 text-sm">£{{ number_format($prod->price, 2) }}</td>
                    <td class="p-4 font-semibold text-slate-700">{{ $prod->quantity }} pcs</td>
                    <td class="p-4">
                        @if($prod->pdf)
                            <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 text-[10px] font-bold px-2 py-0.5 rounded border border-rose-200" title="{{ $prod->pdf->title }}">
                                <i class="fa-solid fa-file-pdf"></i> Attached
                            </span>
                        @else
                            <span class="text-slate-400 text-[10px]">None</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-semibold transition">Edit</a>
                            <form action="{{ route('admin.products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400">No products added yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
