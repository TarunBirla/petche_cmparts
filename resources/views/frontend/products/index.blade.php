@extends('layouts.app')

@section('title', 'All Industrial Products - Petchemparts')

@section('content')

<!-- Header Banner -->
<div class="bg-[#13A1F3] text-white py-10 px-4">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold">All Industrial Products</h1>
            <p class="text-sky-200 text-xs sm:text-sm mt-1">Browse our complete inventory of industrial equipment and Petchemparts.</p>
        </div>

        <div class="text-xs text-sky-200">
            Showing <strong class="text-white">{{ $products->total() }}</strong> Products
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filter Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-28 space-y-6">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                        <i class="fa-solid fa-filter text-sky-600"></i> Filter Products
                    </h3>
                    <a href="{{ route('products.index') }}" class="text-xs text-sky-600 hover:underline font-medium">Reset All</a>
                </div>

                <form action="{{ route('products.index') }}" method="GET" id="catalog-filter-form">
                    
                    <!-- Search Input -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Search Keyword</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Part #, Model #, Name..." class="w-full text-xs pl-8 pr-3 py-2 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
                            <i class="fa-solid fa-search absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category</label>
                        <select name="category" onchange="this.form.submit()" class="w-full text-xs p-2.5 border rounded-lg border-slate-300 bg-white focus:ring-2 focus:ring-sky-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subcategory Filter -->
                    @if($selectedCategory && $selectedCategory->subCategories->count() > 0)
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sub-Category</label>
                            <select name="subcategory" onchange="this.form.submit()" class="w-full text-xs p-2.5 border rounded-lg border-slate-300 bg-white focus:ring-2 focus:ring-sky-500">
                                <option value="">All Sub-categories</option>
                                @foreach($selectedCategory->subCategories as $sub)
                                    <option value="{{ $sub->slug }}" {{ request('subcategory') == $sub->slug ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Manufacturer Filter -->
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Manufacturer</label>
                        <select name="manufacturer" onchange="this.form.submit()" class="w-full text-xs p-2.5 border rounded-lg border-slate-300 bg-white focus:ring-2 focus:ring-sky-500">
                            <option value="">All Manufacturers</option>
                            @foreach($manufacturers as $manuf)
                                <option value="{{ $manuf->slug }}" {{ request('manufacturer') == $manuf->slug ? 'selected' : '' }}>
                                    {{ $manuf->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold py-2.5 rounded-lg shadow-sm transition">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Grid Area -->
        <div class="lg:col-span-3">
            
            <!-- Applied Filter Badges -->
            @if(request()->anyFilled(['search', 'category', 'subcategory', 'manufacturer']))
                <div class="bg-sky-50 border border-sky-200 rounded-xl p-3 mb-6 flex flex-wrap items-center gap-2 text-xs">
                    <span class="font-bold text-sky-900 mr-2">Active Filters:</span>
                    
                    @if(request('search'))
                        <span class="bg-white px-2.5 py-1 rounded-full border border-sky-300 text-sky-800 flex items-center gap-1">
                            Search: "{{ request('search') }}"
                        </span>
                    @endif

                    @if($selectedCategory)
                        <span class="bg-white px-2.5 py-1 rounded-full border border-sky-300 text-sky-800 flex items-center gap-1">
                            Category: {{ $selectedCategory->name }}
                        </span>
                    @endif

                    @if($selectedManufacturer)
                        <span class="bg-white px-2.5 py-1 rounded-full border border-sky-300 text-sky-800 flex items-center gap-1">
                            Brand: {{ $selectedManufacturer->name }}
                        </span>
                    @endif

                    <a href="{{ route('products.index') }}" class="text-sky-600 hover:text-sky-800 font-bold ml-auto">Clear Filters</a>
                </div>
            @endif

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($products as $prod)
                        @php 
                            $img = (!empty($prod->images) && isset($prod->images[0])) ? asset($prod->images[0]) : asset('images/logo.png');
                        @endphp
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col justify-between">
                            <div class="p-4">
                                <div class="relative h-44 w-full bg-slate-50 rounded-xl overflow-hidden mb-3 border border-slate-100 flex items-center justify-center">
                                    <img src="{{ $img }}" alt="{{ $prod->name }}" class="h-full w-full object-contain p-2">
                                    <span class="absolute top-2 right-2 bg-sky-700 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                        {{ $prod->manufacturer->name ?? 'Industrial' }}
                                    </span>
                                </div>

                                <div class="text-[10px] font-semibold text-sky-600 uppercase tracking-wide mb-1">
                                    {{ $prod->category->name ?? 'Equipment' }}
                                </div>
                                
                                <h3 class="font-bold text-sm text-slate-900 line-clamp-2 hover:text-sky-600 transition mb-2">
                                    <a href="{{ route('products.show', $prod->slug) }}">{{ $prod->name }}</a>
                                </h3>

                                <div class="text-xs text-slate-500 space-y-1 mb-3">
                                    <div><strong class="text-slate-700">Part #:</strong> {{ $prod->part_number }}</div>
                                    <div><strong class="text-slate-700">Model #:</strong> {{ $prod->model_number }}</div>
                                </div>
                            </div>

                            <div class="px-4 pb-4 pt-2 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block">Unit Price:</span>
                                    <span class="text-base font-bold text-sky-900">£{{ number_format($prod->price, 2) }}</span>
                                </div>

                                <div class="flex gap-1.5">
                                    <a href="{{ route('products.show', $prod->slug) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 p-2 rounded-lg text-xs" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button onclick="addToRequest({{ $prod->id }}, '{{ addslashes($prod->name) }}', '{{ addslashes($prod->part_number) }}', {{ $prod->price }}, '{{ $img }}', this)" class="bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition flex items-center gap-1 shadow-sm shadow-sky-200">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Request</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg">No Products Found</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">We couldn't find any products matching your search criteria. Try adjusting your filters or search keywords.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">Clear Search</a>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
