@extends('layouts.app')

@section('title', 'All Manufacturers & Brands - Petchemparts')

@section('content')

<!-- Header Banner -->
<div class="bg-[#13A1F3] text-white py-12 px-4">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <span class="inline-block bg-sky-500/20 text-sky-200 border border-sky-400/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                Authorized & Sourced OEM Manufacturers
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold">All Industrial Manufacturers</h1>
            <p class="text-sky-200 text-xs sm:text-sm mt-1">Explore equipment from leading global brands in oil, gas, and Petchemparts automation.</p>
        </div>

        <div class="text-xs text-sky-200 bg-sky-800/60 px-4 py-2 rounded-xl border border-sky-700">
            Total Brands: <strong class="text-white text-base ml-1">{{ $manufacturers->total() }}</strong>
        </div>
    </div>
</div>

<!-- Manufacturers Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($manufacturers as $manuf)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:border-sky-300 transition duration-300 flex flex-col justify-between items-center text-center">
                <div class="w-full flex flex-col items-center">
                    <h2 class="font-bold text-lg text-slate-900 hover:text-sky-600 transition mb-1">{{ $manuf->name }}</h2>
                    <span class="inline-block bg-sky-50 text-sky-800 text-xs font-semibold px-3 py-1 rounded-full border border-sky-200 mb-4">
                        {{ $manuf->products_count }} Available Products
                    </span>
                </div>

                <a href="{{ route('products.index', ['manufacturer' => $manuf->slug]) }}" class="w-full bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold py-2.5 rounded-xl text-center transition shadow-sm shadow-sky-200 flex items-center justify-center gap-2">
                    <span>View Brand Products</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links (8 items per page) -->
    <div class="mt-10 flex justify-center">
        {{ $manufacturers->links() }}
    </div>
</div>

@endsection
