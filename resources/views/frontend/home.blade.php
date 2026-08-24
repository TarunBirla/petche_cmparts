@extends('layouts.app')

@section('title', 'Petchemparts - Petchemparts Petrochemical & Industrial Parts Reseller')

@section('content')

<!-- Hero Section -->
<section class="relative bg-[#13A1F3] text-white py-10 lg:py-16 px-4 sm:px-6 lg:px-8 ">
    <div class="max-w-5xl mx-auto text-center space-y-2">
        
        <h1 class="text-2xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight leading-tight">
            High-Performance Petrochemical & Industrial Equipment Spares</span>
        </h1>
        <p class=" text-[16px] sm:text-base max-w-3xl mx-auto leading-relaxed">
            Sourcing over 500+ top European and USA brands. Find control valves, transmitters, flow meters, actuators, and MRO spare parts with direct Petchemparts quotation.
        </p>

        <!-- Search Bar in Hero -->
        <div class="pt-4 max-w-3xl mx-auto">
            <form action="{{ route('products.index') }}" method="GET" class="bg-white p-2.5 rounded-2xl shadow-2xl flex flex-col sm:flex-row items-center gap-2 border border-sky-100">
                <div class="relative w-full sm:flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="search" placeholder="Search by Product Name, Part #, Model #..." class="w-full text-[16px] sm:text-sm pl-11 pr-4 py-3 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium placeholder-slate-400">
                </div>
                <div class="w-full sm:w-52">
                    <select name="manufacturer" class="w-full text-[16px] sm:text-sm px-3 py-3 rounded-xl text-white bg-[#13A1F3] border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium">
                        <option value="">All Manufacturers</option>
                        @foreach($manufacturers as $manuf)
                            <option value="{{ $manuf->slug }}">{{ $manuf->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full sm:w-auto bg-[#13A1F3] hover:bg-[#13A1F3] text-white font-bold text-[16px] sm:text-sm px-8 py-3.5 rounded-xl shadow-lg shadow-sky-900/30 transition flex items-center justify-center gap-2">
                    <span>Search Parts</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 pt-4 text-[16px] text-sky-200 font-medium">
            <span class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-sky-400 text-sm"></i> Direct Petchemparts Pricing (£)</span>
            <span class="flex items-center gap-2"><i class="fa-solid fa-file-pdf text-sky-400 text-sm"></i> Datasheet PDFs</span>
            <span class="flex items-center gap-2"><i class="fa-solid fa-boxes-packing text-sky-400 text-sm"></i> Instant Quote Request</span>
        </div> -->
    </div>
</section>



<!-- Manufacturers Showcase (Swiper Slider Carousel) -->
<section id="manufacturers" class="py-10   shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-[#13A1F3] block mb-1">OEM Brands Directory</span>
                <h2 class="text-2xl font-extrabold text-slate-900">Top Brands & Manufacturers</h2>
                <p class="text-[16px] sm:text-sm text-slate-500 mt-1">Authorized & sourced industrial equipment manufacturers</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('manufacturers.index') }}" class="text-[16px] sm:text-sm font-bold text-[#13A1F3] hover:text-[#13A1F3] transition flex items-center gap-1 mr-2">
                    View All Brands <i class="fa-solid fa-chevron-right text-[16px]"></i>
                </a>
                <button id="manuf-prev"  class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-[#13A1F3] hover:bg-[#13A1F3] hover:text-white hover:border-sky-600 transition shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-chevron-left text-[16px]"></i>
                </button>
                <button id="manuf-next"  class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-[#13A1F3] hover:bg-[#13A1F3] hover:text-white hover:border-sky-600 transition shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-chevron-right text-[16px]"></i>
                </button>
            </div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper manuf-swiper py-1">
            <div class="swiper-wrapper">
                @foreach($manufacturers as $manuf)
                    <div class="swiper-slide h-auto">
                        <a href="{{ route('products.index', ['manufacturer' => $manuf->slug]) }}" class="bg-white/5 border border-white/10 hover:border-sky-400/60 rounded-2xl p-4 flex flex-col items-center justify-center text-center shadow-md hover:bg-white/10 transition-all duration-300 h-full group ">
                            
                            <span class="text-[16px] font-bold text-slate-900 group-hover:text-sky-300 transition truncate w-full">{{ $manuf->name }}</span>
                            <span class="text-[14px] text-slate-500 mt-0.5 font-medium">{{ $manuf->products_count }} Products</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Tabbed Featured Products Section with Manual Navigation Arrows (NO Auto-play) -->
<section class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-6 gap-4">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-widest text-[#13A1F3] block mb-1">Industrial Equipment Catalog</span>
            <h2 class="text-2xl font-extrabold text-slate-900">Featured Products</h2>
            <p class="text-[16px] sm:text-sm text-slate-500 mt-1">Directly available for quote request by category</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('products.index') }}" class="text-[16px] sm:text-sm font-bold text-[#13A1F3] hover:text-[#13A1F3] transition flex items-center gap-1 mr-2">
                See All Catalog <i class="fa-solid fa-chevron-right text-[16px]"></i>
            </a>

            <!-- Manual Slider Arrows -->
            <button id="prod-prev-btn" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-[#13A1F3] hover:bg-[#13A1F3] hover:text-white hover:border-sky-600 transition shadow-sm flex items-center justify-center">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button id="prod-next-btn" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-[#13A1F3] hover:bg-[#13A1F3] hover:text-white hover:border-sky-600 transition shadow-sm flex items-center justify-center">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Category Tabs Navigation -->
    <div class="flex flex-wrap items-center gap-2 mb-8 border-b border-slate-200 pb-4">
        <button onclick="switchProductTab('all', this)" class="prod-tab-btn px-4 py-2.5 rounded-xl text-[16px] font-bold transition bg-[#13A1F3] text-white shadow-md shadow-sky-200">
            All Products
        </button>
        @foreach($topCategories as $topCat)
            <button onclick="switchProductTab('cat-{{ $topCat->id }}', this)" class="prod-tab-btn px-4 py-2.5 rounded-xl text-[16px] font-bold transition bg-slate-100 text-[#13A1F3] hover:bg-[#13A1F3] hover:text-white">
                {{ $topCat->name }}
            </button>
        @endforeach
    </div>

    <!-- Tab Content 0: All Products -->
    <div id="tab-content-all" class="prod-tab-content">
        <div class="swiper prod-swiper-all py-2">
            <div class="swiper-wrapper">
                @foreach($allFeaturedProducts as $prod)
                    <div class="swiper-slide h-auto">
                        @include('frontend.partials.product_card', ['prod' => $prod])
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tab Contents 1..5: Top 5 Categories -->
    @foreach($topCategories as $topCat)
        <div id="tab-content-cat-{{ $topCat->id }}" class="prod-tab-content hidden">
            <div class="swiper prod-swiper-cat-{{ $topCat->id }} py-2">
                <div class="swiper-wrapper">
                    @forelse($topCat->products as $prod)
                        <div class="swiper-slide h-auto">
                            @include('frontend.partials.product_card', ['prod' => $prod])
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400 text-[16px] w-full bg-[#13A1F3] rounded-2xl border border-slate-200">
                            No products currently available in {{ $topCat->name }}.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</section>

<!-- Legal Disclaimer Section -->
<section>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="w-full space-y-3 text-center">

                <h3 class="font-bold text-base sm:text-lg text-slate-900 flex justify-center items-center gap-2">
                    <i class="fa-solid fa-scale-balanced text-[#13A1F3]"></i>
                    Legal Disclaimer
                </h3>

                <p class="text-[16px] text-slate-600 leading-relaxed text-center">
                    Petchemparts is not an authorized dealer, agent or affiliate of any of the designer, brands, or manufacturer, the products of which are offered for sale on www.petchemparts.com. All trademarks, brand names, and logos mentioned are used for identification purposes only and are registered trademarks of their respective owners who reserve the rights of ownership. The use of trademark, brand name or product on our website is not intended to suggest that the company, trademark or brand is affiliated to or endorses our website. All products are 100% genuine and legally purchased from authorized sources.
                </p>

                <div class="text-center">
                    <img src="{{ asset('images/disclaimer.png') }}"
                         alt="Petchemparts Legal Disclaimer Badge"
                         class="h-20 w-auto object-contain mx-auto">
                </div>

            </div>
        </div>
    </div>
</section>

@push('scripts')
<!-- Swiper JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    let activeProductSwiper = null;
    const swiperInstances = {};

    document.addEventListener('DOMContentLoaded', function () {
        // 1. Manufacturers Swiper (Autoplay)
        new Swiper('.manuf-swiper', {
            slidesPerView: 2,
            spaceBetween: 16,
            loop: true,
            observer: true,
            observeParents: true,
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

        // 2. Initialize Swipers for all Product Tabs (STRICTLY NO AUTOPLAY - Manual Arrows & Swipe Only)
        const initProductSwiper = (selector) => {
            return new Swiper(selector, {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: false,
                observer: true,
                observeParents: true,
                autoplay: false, // NO AUTOPLAY
                navigation: {
                    nextEl: '#prod-next-btn',
                    prevEl: '#prod-prev-btn',
                },
                breakpoints: {
                    640: { slidesPerView: 2, spaceBetween: 20 },
                    768: { slidesPerView: 3, spaceBetween: 24 },
                    1024: { slidesPerView: 4, spaceBetween: 24 },
                }
            });
        };

        // All Products Swiper
        swiperInstances['all'] = initProductSwiper('.prod-swiper-all');
        activeProductSwiper = swiperInstances['all'];

        // Category Swipers
        @foreach($topCategories as $topCat)
            swiperInstances['cat-{{ $topCat->id }}'] = initProductSwiper('.prod-swiper-cat-{{ $topCat->id }}');
        @endforeach
    });

    // Tab Switching Function
    function switchProductTab(tabId, btnEl) {
        // Update Buttons Styling
        document.querySelectorAll('.prod-tab-btn').forEach(btn => {
            btn.className = 'prod-tab-btn px-4 py-2.5 rounded-xl text-[16px] font-bold transition bg-slate-100 text-[#13A1F3] hover:bg-[#13A1F3]';
        });
        btnEl.className = 'prod-tab-btn px-4 py-2.5 rounded-xl text-[16px] font-bold transition bg-[#13A1F3] text-white shadow-md shadow-sky-200';

        // Hide all tab contents
        document.querySelectorAll('.prod-tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Show target tab content
        const targetContent = document.getElementById('tab-content-' + tabId);
        if (targetContent) {
            targetContent.classList.remove('hidden');
            if (swiperInstances[tabId]) {
                activeProductSwiper = swiperInstances[tabId];
                activeProductSwiper.update();
            }
        }
    }
</script>
@endpush

@endsection
