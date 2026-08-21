@extends('layouts.app')

@section('title', 'Petchemparts - B2B Petrochemical & Industrial Parts')

@push('styles')
<!-- Swiper CSS CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    .manuf-swiper .swiper-slide { height: auto; }
</style>
@endpush

@section('content')

<!-- Hero Section with Sky Blue Gradient & Search Bar -->
<section class="relative bg-gradient-to-br from-sky-900 via-sky-800 to-slate-900 text-white py-20 px-4">
    <div class="max-w-5xl mx-auto text-center">
        <span class="inline-block bg-sky-500/20 text-sky-200 border border-sky-400/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-4">
            <i class="fa-solid fa-industry mr-1.5"></i> Premium Industrial Petchemparts
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-4 leading-tight">
            Find High-Grade Petchemparts & Equipment
        </h1>
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto mb-8 font-light">
            Search top manufacturers for control valves, pressure transmitters, flow sensors, and instrumentation parts with direct RFQ quote submission.
        </p>

        <!-- Search Box Form -->
        <div class="bg-white p-3 rounded-2xl shadow-2xl max-w-3xl mx-auto border border-sky-100">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                <div class="flex-grow flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-800">
                    <i class="fa-solid fa-magnifying-glass text-sky-600 text-lg mr-3"></i>
                    <input type="text" name="search" placeholder="Search by Product Name, Part Number, or Model Number..." class="w-full bg-transparent focus:outline-none text-sm placeholder:text-slate-400 font-medium">
                </div>

                <div class="sm:w-56 flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                    <i class="fa-solid fa-building-flag text-sky-600 mr-2 text-sm"></i>
                    <select name="manufacturer" class="w-full bg-transparent text-slate-700 text-xs focus:outline-none font-medium cursor-pointer">
                        <option value="">All Manufacturers</option>
                        @foreach($manufacturers as $manuf)
                            <option value="{{ $manuf->slug }}">{{ $manuf->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                    <span>Search</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <div class="flex items-center justify-center gap-8 mt-8 text-xs text-sky-200">
            <span><i class="fa-solid fa-check text-sky-400 mr-1.5"></i> Direct B2B Pricing (£)</span>
            <span><i class="fa-solid fa-file-pdf text-sky-400 mr-1.5"></i> Datasheet PDFs</span>
            <span><i class="fa-solid fa-boxes-packing text-sky-400 mr-1.5"></i> Instant Quote Request</span>
        </div>
    </div>
</section>

<!-- Categories & Sub-Categories Section -->
<section id="categories" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Explore Product Categories & Sub-Categories</h2>
            <p class="text-sm text-slate-500 mt-1">Select an industrial category or sub-category to view available spare parts</p>
        </div>
        <a href="{{ route('categories.index') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-800 transition flex items-center gap-1">
            View All Categories <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $cat)
            @php $catImg = ($cat->image && file_exists(public_path($cat->image))) ? asset($cat->image) : asset('images/logo.png'); @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl hover:border-sky-300 transition duration-300 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                        <h3 class="font-bold text-base text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-sky-600"></i>
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="hover:text-sky-600 transition">{{ $cat->name }}</a>
                        </h3>
                        <span class="bg-sky-50 text-sky-700 text-[10px] font-extrabold px-2.5 py-1 rounded-full border border-sky-100">
                            {{ $cat->subCategories->count() }} Sub-Categories
                        </span>
                    </div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Sub-Categories:</p>
                    
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($cat->subCategories as $sub)
                            <a href="{{ route('products.index', ['subcategory' => $sub->slug]) }}" class="bg-slate-50 hover:bg-sky-600 hover:text-white text-slate-700 text-[11px] font-medium px-2.5 py-1 rounded-lg border border-slate-200/80 transition flex items-center gap-1">
                                <i class="fa-solid fa-chevron-right text-[8px] text-sky-500"></i>
                                <span>{{ $sub->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
                    <span class="text-slate-500">{{ $cat->products_count }} Available Products</span>
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="font-semibold text-sky-600 hover:text-sky-800 transition flex items-center gap-1">
                        View Category <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Manufacturers Showcase (Swiper Slider Carousel) -->
<section id="manufacturers" class="py-14 bg-gradient-to-r from-sky-50/80 via-white to-sky-50/80 border-y border-sky-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-sky-950">Top Brands & Manufacturers</h2>
                <p class="text-sm text-slate-600 mt-1">Authorized & sourced industrial equipment manufacturers</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('manufacturers.index') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-800 transition flex items-center gap-1 mr-2">
                    View All Brands <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
                <button id="manuf-prev" class="w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-600 hover:bg-sky-600 hover:text-white transition shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button id="manuf-next" class="w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-600 hover:bg-sky-600 hover:text-white transition shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper manuf-swiper py-2">
            <div class="swiper-wrapper">
                @foreach($manufacturers as $manuf)
                    <div class="swiper-slide">
                        <a href="{{ route('products.index', ['manufacturer' => $manuf->slug]) }}" class="bg-white border border-slate-200 rounded-2xl p-5 flex flex-col items-center justify-center text-center shadow-sm hover:border-sky-400 hover:shadow-lg transition duration-300 h-full group">
                            <div class="h-16 w-full flex items-center justify-center mb-3">
                                @if($manuf->logo && file_exists(public_path($manuf->logo)))
                                    <img src="{{ asset($manuf->logo) }}" alt="{{ $manuf->name }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition">
                                @else
                                    <div class="w-12 h-12 bg-sky-100 text-sky-700 rounded-full flex items-center justify-center font-extrabold text-base">
                                        {{ substr($manuf->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <span class="text-xs font-bold text-slate-800 group-hover:text-sky-600 transition truncate w-full">{{ $manuf->name }}</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">{{ $manuf->products_count }} Products</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Featured Products</h2>
            <p class="text-sm text-slate-500 mt-1">Directly available for quote request</p>
        </div>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-800 transition flex items-center gap-1">
            See All Catalog <i class="fa-solid fa-chevron-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($featuredProducts as $prod)
            @php 
                $img = (!empty($prod->images) && isset($prod->images[0])) ? asset($prod->images[0]) : asset('images/logo.png');
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col justify-between">
                <div class="p-4">
                    <div class="relative h-48 w-full bg-slate-50 rounded-xl overflow-hidden mb-4 border border-slate-100 flex items-center justify-center">
                        <img src="{{ $img }}" alt="{{ $prod->name }}" class="h-full w-full object-contain p-2">
                        <span class="absolute top-2 right-2 bg-sky-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ $prod->manufacturer->name ?? 'Industrial' }}
                        </span>
                    </div>

                    <div class="text-[11px] font-semibold text-sky-600 uppercase tracking-wide mb-1">
                        {{ $prod->category->name ?? 'Product' }}
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
                        <span class="text-xs text-slate-400 block">Unit Price:</span>
                        <span class="text-base font-bold text-sky-900">£{{ number_format($prod->price, 2) }}</span>
                    </div>

                    <button onclick="addToRequest({{ $prod->id }}, '{{ addslashes($prod->name) }}', '{{ addslashes($prod->part_number) }}', {{ $prod->price }}, '{{ $img }}', this)" class="bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition flex items-center gap-1 shadow-sm shadow-sky-200">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Request</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Legal Disclaimer Section -->
<section class="py-12 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row items-center gap-8 shadow-sm">
            <div class="md:w-1/4 flex-shrink-0 text-center">
                <img src="{{ asset('images/disclaimer.png') }}" alt="Petchemparts Legal Disclaimer Badge" class="h-44 w-auto object-contain mx-auto">
            </div>
            <div class="md:w-3/4 space-y-3">
                <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-scale-balanced text-sky-600"></i> Legal Disclaimer
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Petchemparts is not an authorized dealer, agent or affiliate of any of the designer, brands, or manufacturer, the products of which are offered for sale on www.petchemparts.com. All trademarks, brand names, and logos mentioned are used for identification purposes only and are registered trademarks of their respective owners who reserve the rights of ownership. The use of trademark, brand name or product on our website is not intended to suggest that the company, trademark or brand is affiliated to or endorses our website. All products are 100% genuine and legally purchased from authorized sources.
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<!-- Swiper JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.manuf-swiper', {
            slidesPerView: 2,
            spaceBetween: 16,
            loop: true,
            autoplay: {
                delay: 2800,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '#manuf-next',
                prevEl: '#manuf-prev',
            },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 20 },
                768: { slidesPerView: 4, spaceBetween: 20 },
                1024: { slidesPerView: 5, spaceBetween: 24 },
                1280: { slidesPerView: 6, spaceBetween: 24 },
            }
        });
    });
</script>
@endpush

@endsection
