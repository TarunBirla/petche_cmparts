@extends('layouts.app')

@section('title', 'All Product Categories - Petchemparts')

@section('content')

<!-- Header Banner -->
<div class="bg-gradient-to-r from-sky-900 via-sky-800 to-slate-900 text-white py-12 px-4">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <span class="inline-block bg-sky-500/20 text-sky-200 border border-sky-400/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                Product Taxonomy
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold">All Product Categories</h1>
            <p class="text-sky-200 text-xs sm:text-sm mt-1">Browse our complete range of industrial equipment, control valves, and petrochemical instrumentation.</p>
        </div>

        <div class="text-xs text-sky-200 bg-sky-800/60 px-4 py-2 rounded-xl border border-sky-700">
            Total Categories: <strong class="text-white text-base ml-1">{{ $categories->count() }}</strong>
        </div>
    </div>
</div>

<!-- Main Categories Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $cat)
            @php $catImg = $cat->image ? asset($cat->image) : asset('images/logo.png'); @endphp
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-sky-300 transition duration-300 overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Category Image Banner -->
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="block relative h-52 bg-slate-50 overflow-hidden border-b border-slate-100 group">
                        <img src="{{ $catImg }}" alt="{{ $cat->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 right-3 bg-sky-900/80 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                            {{ $cat->products_count }} Products
                        </span>
                    </a>

                    <div class="p-6">
                        <h2 class="font-bold text-xl text-slate-900 hover:text-sky-600 transition mb-3">
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
                        </h2>

                        <!-- Sub-categories List -->
                        @if($cat->subCategories->count() > 0)
                            <div class="mb-4">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Sub-categories:</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($cat->subCategories as $sub)
                                        <a href="{{ route('products.index', ['category' => $cat->slug, 'subcategory' => $sub->slug]) }}" class="bg-sky-50 hover:bg-sky-600 hover:text-white text-sky-800 border border-sky-200 text-xs px-2.5 py-1 rounded-lg transition font-medium">
                                            {{ $sub->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-slate-400 mb-4">Direct product category</p>
                        @endif
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="w-full bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold py-2.5 rounded-xl text-center transition shadow-sm shadow-sky-200 flex items-center justify-center gap-2">
                        <span>Explore Category Products</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
