@extends('layouts.app')

@section('title', 'Petchemparts - Industrial & Petrochemical Parts Reseller')

@section('content')

<!-- ============================================================ -->
<!-- HERO — split layout: copy + search on the left,               -->
<!-- a floating "spec card" stack on the right (signature element) -->
<!-- ============================================================ -->
<section class="relative overflow-hidden bg-[var(--primary-dark)] text-white">
    <div class="absolute inset-0 blueprint-bg opacity-30"></div>
    <div class="absolute -right-32 -top-32 w-[28rem] h-[28rem] rounded-full bg-accent/10 blur-3xl"></div>
    <div class="absolute -left-24 bottom-0 w-72 h-72 rounded-full bg-white/5 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
        <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">

            <!-- Left: copy + search -->
            <div class="text-center lg:text-left">
                <span class="inline-flex items-center gap-2 font-mono text-xs tracking-widest text-accent bg-white/5 border border-white/10 px-3 py-1.5 rounded-full mb-5">
                    <i class="fa-solid fa-check-circle"></i> 500+ VERIFIED OEM MANUFACTURERS SOURCED
                </span>

                <h1 class="font-display text-3xl sm:text-5xl font-bold tracking-tight leading-[1.1] mb-4">
                    High-Performance Industrial Equipment Spares
                </h1>
                <p class="text-white/70 text-[16px] sm:text-lg max-w-xl mx-auto lg:mx-0 leading-relaxed mb-7">
                    Sourcing over 500+ top European and USA manufacturers. Control valves, transmitters, flow meters, actuators &amp; MRO spares — with a direct quotation, every time.
                </p>

                <form action="{{ route('products.index') }}" method="GET" class="bg-white p-2.5 rounded-2xl shadow-2xl flex flex-col sm:flex-row items-center gap-2 max-w-xl mx-auto lg:mx-0">
                    <div class="relative w-full sm:flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] text-sm"></i>
                        <input type="text" name="search" placeholder="Search by Product Name, Part #, Model #..." class="w-full text-[16px] sm:text-sm pl-11 pr-4 py-3 rounded-xl text-[var(--text)] focus:outline-none font-medium placeholder-[var(--text-muted)]">
                    </div>
                    <div class="w-full sm:w-48 relative">
                        <select name="manufacturer" class="w-full text-[15px] sm:text-xs px-3.5 py-3 rounded-xl text-slate-800 bg-slate-100 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[var(--primary)] font-semibold cursor-pointer appearance-none pr-8">
                            <option value="">All Manufacturers</option>
                            @foreach($manufacturers as $manuf)
                                <option value="{{ $manuf->slug }}">{{ $manuf->name }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                    </div>
                    <button type="submit" class="cta-clip w-full sm:w-auto bg-accent hover:bg-accent-dark text-white font-bold text-[16px] sm:text-sm px-7 py-3.5 shadow-lg transition flex items-center justify-center gap-2">
                        <span>Search</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-x-7 gap-y-3 pt-7 text-xs sm:text-sm text-white/60 font-semibold">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-file-invoice-dollar text-accent"></i> Direct Quotation Pricing</span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-file-pdf text-accent"></i> Datasheet PDFs</span>
                    <span class="flex items-center gap-2"><i class="fa-solid fa-truck-fast text-accent"></i> Global Dispatch</span>
                </div>
            </div>

            <!-- Right: floating spec-card stack (signature visual) -->
            <div class="relative hidden lg:block h-[420px]">
                <div class="absolute inset-0 rounded-3xl border border-white/10 bg-white/[0.03] blueprint-bg"></div>

                <!-- Card 1 -->
                <div class="absolute top-6 left-4 w-64 bg-white text-[var(--text)] rounded-2xl shadow-2xl p-4 rotate-[-4deg] hover:rotate-0 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-[var(--primary-light)] flex items-center justify-center text-primary"><i class="fa-solid fa-gauge-high"></i></div>
                        <div>
                            <div class="font-semibold text-sm leading-tight">Pressure Transmitter</div>
                            <div class="spec-tag text-[10px] text-[var(--text-muted)]">RM-3051-CD</div>
                        </div>
                    </div>
                    <div class="text-[11px] text-[var(--text-muted)] font-mono">Range: 0–400 bar · IP66</div>
                </div>

                <!-- Card 2 -->
                <div class="absolute top-40 right-2 w-60 bg-white text-[var(--text)] rounded-2xl shadow-2xl p-4 rotate-[3deg] hover:rotate-0 transition-transform duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-[var(--primary-light)] flex items-center justify-center text-primary"><i class="fa-solid fa-diagram-project"></i></div>
                        <div>
                            <div class="font-semibold text-sm leading-tight">Control Valve V150</div>
                            <div class="spec-tag text-[10px] text-[var(--text-muted)]">FS-V150-3</div>
                        </div>
                    </div>
                    <div class="text-[11px] text-[var(--text-muted)] font-mono">DN50 · ANSI 300#</div>
                </div>

                <!-- Card 3 -->
                <div class="absolute bottom-4 left-14 w-56 bg-accent text-white rounded-2xl shadow-2xl p-4 rotate-[-2deg] hover:rotate-0 transition-transform duration-300">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-bolt text-white/90"></i>
                        <span class="font-display font-bold text-sm">24hr Quote Turnaround</span>
                    </div>
                    <div class="text-[11px] text-white/80">Send a request, get a priced quotation next working day.</div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- MANUFACTURERS — premium sourcing-partner directory            -->
<!-- ============================================================ -->
<section id="manufacturers" class="py-16 bg-[var(--surface)] border-b border-token">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-9 gap-4">
            <div>
                <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-accent block mb-1">Authorized Sourcing Partners</span>
                <h2 class="font-display text-2xl sm:text-3xl font-bold text-[var(--text)]">Top Manufacturers</h2>
                <p class="text-sm text-[var(--text-muted)] mt-1.5">{{ $manufacturers->count() }}+ OEM manufacturers available for direct-quotation sourcing</p>
            </div>
            <a href="{{ route('manufacturers.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:text-[var(--primary-dark)] transition border border-token hover:border-primary rounded-xl px-4 py-2.5">
                View All Manufacturers <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach($manufacturers->take(6) as $manuf)
                <a href="{{ route('products.index', ['manufacturer' => $manuf->slug]) }}"
                   class="group relative bg-[var(--bg)] border border-token hover:border-primary rounded-2xl p-5 flex flex-col items-center text-center shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <span class="absolute top-0 left-0 right-0 h-1 bg-primary scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></span>
                    <!-- <div class="w-12 h-12 rounded-xl bg-white border border-token flex items-center justify-center font-display font-bold text-primary text-base mb-3 shadow-sm">
                        {{ strtoupper(substr($manuf->name, 0, 2)) }}
                    </div> -->
                    <span class="font-display text-[13px] font-bold text-[var(--text)] truncate w-full">{{ $manuf->name }}</span>
                    <span class="spec-tag text-[11px] text-[var(--text-muted)] mt-1">{{ $manuf->products_count }} parts</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- FEATURED PRODUCTS — segmented pill tabs                       -->
<!-- ============================================================ -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-7 gap-4">
        <div>
            <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-accent block mb-1">Industrial Equipment Catalog</span>
            <h2 class="font-display text-2xl sm:text-3xl font-bold text-[var(--text)]">Featured Products</h2>
            <p class="text-sm text-[var(--text-muted)] mt-1.5">Directly available for quote request, by category</p>
        </div>

        <div class="flex items-center gap-2">
            <button id="prod-prev-btn" class="w-10 h-10 rounded-full bg-[var(--bg)] border border-token text-primary hover:bg-primary hover:text-white transition shadow-sm flex items-center justify-center">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button id="prod-next-btn" class="w-10 h-10 rounded-full bg-[var(--bg)] border border-token text-primary hover:bg-primary hover:text-white transition shadow-sm flex items-center justify-center">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Segmented pill tab bar -->
    <div class="inline-flex flex-wrap items-center gap-1 bg-[var(--bg)] border border-token rounded-2xl p-1.5 mb-9">
        <button onclick="switchProductTab('all', this)" class="prod-tab-btn px-5 py-2.5 rounded-xl text-[14px] font-bold transition bg-primary text-white shadow-md flex items-center gap-2">
            <i class="fa-solid fa-layer-group text-xs"></i> All Products
        </button>
        @foreach($topCategories as $topCat)
            <button onclick="switchProductTab('cat-{{ $topCat->id }}', this)" class="prod-tab-btn px-5 py-2.5 rounded-xl text-[14px] font-bold transition text-[var(--text-muted)] hover:text-primary hover:bg-white flex items-center gap-2">
                <i class="fa-solid fa-circle text-[6px]"></i> {{ $topCat->name }}
            </button>
        @endforeach
    </div>

    <!-- Tab Content: All Products -->
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

    <!-- Tab Contents: Top Categories -->
    @foreach($topCategories as $topCat)
        <div id="tab-content-cat-{{ $topCat->id }}" class="prod-tab-content hidden">
            <div class="swiper prod-swiper-cat-{{ $topCat->id }} py-2">
                <div class="swiper-wrapper">
                    @forelse($topCat->products as $prod)
                        <div class="swiper-slide h-auto">
                            @include('frontend.partials.product_card', ['prod' => $prod])
                        </div>
                    @empty
                        <div class="p-12 text-center text-[var(--text-muted)] text-[16px] w-full bg-[var(--bg)] rounded-2xl border border-token">
                            No products currently available in {{ $topCat->name }}.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</section>

<!-- Trust Strip -->
<section class="bg-[var(--primary-light)] py-10 border-y border-token">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div>
            <div class="font-display text-2xl font-bold text-primary">500+</div>
            <div class="text-xs text-[var(--text-muted)] font-semibold mt-1">OEM Manufacturers</div>
        </div>
        <div>
            <div class="font-display text-2xl font-bold text-primary">{{ $allFeaturedProducts->count() > 0 ? '12k+' : '0' }}</div>
            <div class="text-xs text-[var(--text-muted)] font-semibold mt-1">Parts Catalogued</div>
        </div>
        <div>
            <div class="font-display text-2xl font-bold text-primary">40+</div>
            <div class="text-xs text-[var(--text-muted)] font-semibold mt-1">Countries Served</div>
        </div>
        <div>
            <div class="font-display text-2xl font-bold text-primary">24hr</div>
            <div class="text-xs text-[var(--text-muted)] font-semibold mt-1">Quote Turnaround</div>
        </div>
    </div>
</section>

<!-- Legal Disclaimer Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="w-full space-y-3 text-left">
            <h3 class="font-display font-bold text-base sm:text-lg text-[var(--text)] flex justify-start items-center gap-2">
                <i class="fa-solid fa-scale-balanced text-primary"></i>
                Legal Disclaimer
            </h3>
            <p class="text-[15px] text-[var(--text-muted)] leading-relaxed text-left max-w-5xl">
                Petchemparts is not an authorized dealer, agent or affiliate of any of the designer, brands, or manufacturer, the products of which are offered for sale on www.petchemparts.com. All trademarks, brand names, and logos mentioned are used for identification purposes only and are registered trademarks of their respective owners who reserve the rights of ownership. The use of trademark, brand name or product on our website is not intended to suggest that the company, trademark or brand is affiliated to or endorses our website. All products are 100% genuine and legally purchased from authorized sources.
            </p>
            <div class="text-center pt-2">
                <img src="{{ asset('images/disclaimer.png') }}" alt="Petchemparts Legal Disclaimer Badge" class="h-20 w-auto object-contain mx-auto">
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    let activeProductSwiper = null;
    const swiperInstances = {};

    document.addEventListener('DOMContentLoaded', function () {
        const initProductSwiper = (selector) => new Swiper(selector, {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            observer: true,
            observeParents: true,
            autoplay: false,
            navigation: { nextEl: '#prod-next-btn', prevEl: '#prod-prev-btn' },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 24 },
                1024: { slidesPerView: 4, spaceBetween: 24 },
            }
        });

        swiperInstances['all'] = initProductSwiper('.prod-swiper-all');
        activeProductSwiper = swiperInstances['all'];

        @foreach($topCategories as $topCat)
            swiperInstances['cat-{{ $topCat->id }}'] = initProductSwiper('.prod-swiper-cat-{{ $topCat->id }}');
        @endforeach
    });

    function switchProductTab(tabId, btnEl) {
        document.querySelectorAll('.prod-tab-btn').forEach(btn => {
            btn.className = 'prod-tab-btn px-5 py-2.5 rounded-xl text-[14px] font-bold transition text-[var(--text-muted)] hover:text-primary hover:bg-white flex items-center gap-2';
        });
        btnEl.className = 'prod-tab-btn px-5 py-2.5 rounded-xl text-[14px] font-bold transition bg-primary text-white shadow-md flex items-center gap-2';

        document.querySelectorAll('.prod-tab-content').forEach(content => content.classList.add('hidden'));

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