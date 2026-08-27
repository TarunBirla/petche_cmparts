<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Petchemparts - Industrial & Petrochemical Parts')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#E7F4F3',
                            100: '#cde8e6',
                            200: '#9bd2ce',
                            300: '#6abcb6',
                            400: '#38a59e',
                            500: '#0F6B66',
                            600: '#0F6B66',
                            700: '#0A4744',
                            800: '#073533',
                            900: '#042322',
                            950: '#021413',
                        },
                        accent: {
                            500: '#F2A541',
                            600: '#F2A541',
                            700: '#C8811F',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <style>
        /* ================================================================
           THEME TOKENS — change ONLY this block to switch color themes.
           Pick any of the 10 palettes from theme-preview.html and paste
           the 5 values below. This is the "Steel Blueprint" theme (#1).
        ================================================================ */
        :root{
        --primary:#0F6B66; --primary-dark:#0A4744; --primary-light:#E7F4F3;
--accent:#F2A541;  --accent-dark:#C8811F;
            --bg:            #F6F8FA;
            --surface:       #FFFFFF;
            --text:          #101828;
            --text-muted:    #5B6472;
            --border:        #E1E6EB;
        }

        body{ font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); }
        .font-display{ font-family:'Space Grotesk',sans-serif; }
        .font-mono{ font-family:'JetBrains Mono',monospace; }
        .bg-primary{ background:var(--primary); } .bg-primary-dark{ background:var(--primary-dark); }
        .bg-primary-light{ background:var(--primary-light); } .text-primary{ color:var(--primary); }
        .hover\:bg-primary-dark:hover{ background:var(--primary-dark); }
        .hover\:text-primary:hover{ color:var(--primary); }
        .text-accent{ color:var(--accent); } .bg-accent{ background:var(--accent); }
        .hover\:bg-accent-dark:hover{ background:var(--accent-dark); }
        .border-token{ border-color:var(--border); } .text-muted{ color:var(--text-muted); }
        [x-cloak]{ display:none !important; }

        /* Signature: machined-corner CTA (evokes a chamfered industrial part) */
        .cta-clip{ clip-path: polygon(0 0, 100% 0, 100% 70%, 92% 100%, 0 100%); }

        /* Signature: faint engineering blueprint grid, used in hero/dark sections */
        .blueprint-bg{
            background-image:
                linear-gradient(rgba(255,255,255,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .spec-tag{ font-family:'JetBrains Mono',monospace; letter-spacing:.02em; }

        .swiper{ overflow:hidden; position:relative; width:100%; }
        .swiper-wrapper{ display:flex !important; flex-direction:row !important; transition-property:transform; box-sizing:content-box; width:100%; }
        .swiper-slide{ flex-shrink:0 !important; position:relative; transition-property:transform; }

        ::selection{ background:var(--primary); color:#fff; }
    </style>
    @stack('styles')
</head>
<body class="bg-[var(--bg)] text-[var(--text)] flex flex-col min-h-screen">

   

    <!-- Main Navigation Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40 border-b border-token">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <img class="h-11 w-auto object-contain" src="{{ asset('images/logo.png') }}" alt="Petchemparts Logo">
                    </a>
                </div>

                <nav class="hidden md:flex space-x-8 items-center font-semibold text-sm text-[var(--text)]">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-primary' : 'hover:text-primary' }} transition">Home</a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-primary' : 'hover:text-primary' }} transition">All Products</a>
                    <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'text-primary' : 'hover:text-primary' }} transition">Categories</a>
                    <a href="{{ route('manufacturers.index') }}" class="{{ request()->routeIs('manufacturers.*') ? 'text-primary' : 'hover:text-primary' }} transition">Manufacturers</a>
                    <a href="{{ route('about-us') }}" class="{{ request()->routeIs('about-us') ? 'text-primary' : 'hover:text-primary' }} transition">About Us</a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-primary' : 'hover:text-primary' }} transition">Contact Us</a>
                </nav>

                <div class="flex items-center gap-3">
                    <button id="open-request-btn" onclick="handleHeaderRequestClick()" class="cta-clip relative bg-primary hover:bg-primary-dark text-white px-4 py-2.5 font-semibold shadow-md transition flex items-center gap-2 text-xs sm:text-sm">
                        <i class="fa-solid fa-clipboard-list text-base"></i>
                        <span class="hidden sm:inline">Request List</span>
                        <span id="request-badge-count" class="bg-white/20 text-white text-xs font-extrabold px-2 py-0.5 rounded-full ml-0.5">0</span>
                    </button>

                    <button onclick="toggleMobileMenu()" class="md:hidden text-[var(--text)] hover:text-primary p-2 text-xl focus:outline-none" aria-label="Toggle Mobile Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-[var(--primary-dark)] text-white border-t border-white/10 px-4 py-4 space-y-1 text-sm font-semibold">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('home') ? 'bg-white/10' : 'hover:bg-white/5' }}">Home</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('products.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">All Products</a>
            <a href="{{ route('categories.index') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">Categories</a>
            <a href="{{ route('manufacturers.index') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('manufacturers.*') ? 'bg-white/10' : 'hover:bg-white/5' }}">Manufacturers</a>
            <a href="{{ route('about-us') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('about-us') ? 'bg-white/10' : 'hover:bg-white/5' }}">About Us</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2.5 rounded-lg {{ request()->routeIs('contact') ? 'bg-white/10' : 'hover:bg-white/5' }}">Contact Us</a>
        </div>
    </header>

    <!-- Global Header Search Bar (On Every Page Except Products Catalog Page & Home Page) -->
    @if(!request()->routeIs('products.index') && !request()->routeIs('home'))
        <div class="bg-[var(--primary-dark)] border-b border-white/10 py-3 px-4 shadow-md">
            <div class="max-w-7xl mx-auto">
                <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2">
                    <div class="relative w-full sm:flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-white/40 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Product Name, Part # or Model #..." class="w-full text-xs pl-9 pr-4 py-2.5 rounded-xl bg-white/10 text-white placeholder-white/40 border border-white/10 focus:outline-none focus:ring-2 focus:ring-[var(--accent)] font-medium">
                    </div>
                    <div class="w-full sm:w-48 relative">
                        <select name="manufacturer" class="w-full text-xs px-3.5 py-2.5 rounded-xl text-slate-800 bg-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-[var(--accent)] font-semibold cursor-pointer appearance-none pr-8 shadow-sm">
                            <option value="" class="text-slate-800 bg-white">All Manufacturers</option>
                            @foreach(\App\Models\Manufacturer::where('is_active', true)->orderBy('name')->get() as $manuf)
                                <option value="{{ $manuf->slug }}" class="text-slate-800 bg-white" {{ request('manufacturer') == $manuf->slug ? 'selected' : '' }}>{{ $manuf->name }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 text-[10px] pointer-events-none"></i>
                    </div>
                    <button type="submit" class="cta-clip w-full sm:w-auto bg-accent hover:bg-accent-dark text-white text-xs font-bold px-6 py-2.5 transition flex items-center justify-center gap-1.5 shadow-md">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        <span>Search</span>
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm flex justify-between items-center">
                    <div><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold">&times;</button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[var(--primary-dark)] text-white/70 mt-16 border-t-4 border-accent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img class="h-10 w-auto bg-white p-1 rounded" src="{{ asset('images/logo.png') }}" alt="Petchemparts">
                    </div>
                    <p class="text-white/50 text-xs leading-relaxed mb-3">
                        UK's leading industrial, oil and gas spare parts, consumable & MRO reseller globally.
                    </p>
                    <div class="text-[11px] text-accent font-semibold">
                        <i class="fa-solid fa-clock mr-1"></i> 7 Days a week: 9:00 am - 7:00 pm
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-display font-semibold text-base mb-4 border-b border-white/10 pb-2">Information Links</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('about-us') }}" class="hover:text-accent transition"><i class="fa-solid fa-chevron-right text-[10px] text-accent mr-2"></i>About Us</a></li>
                        <li><a href="{{ route('delivery') }}" class="hover:text-accent transition"><i class="fa-solid fa-chevron-right text-[10px] text-accent mr-2"></i>Delivery and Returns</a></li>
                        <li><a href="{{ route('terms-and-conditions') }}" class="hover:text-accent transition"><i class="fa-solid fa-chevron-right text-[10px] text-accent mr-2"></i>Terms and Conditions</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-accent transition"><i class="fa-solid fa-chevron-right text-[10px] text-accent mr-2"></i>Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-display font-semibold text-base mb-4 border-b border-white/10 pb-2">Product Catalog</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('products.index') }}" class="hover:text-accent transition"><i class="fa-solid fa-chevron-right text-[10px] text-accent mr-2"></i>All Products</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-accent transition"><i class="fa-solid fa-chevron-right text-[10px] text-accent mr-2"></i>Product Categories</a></li>
                        <li><a href="{{ route('manufacturers.index') }}" class="hover:text-accent transition"><i class="fa-solid fa-chevron-right text-[10px] text-accent mr-2"></i>OEM Manufacturers</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-display font-semibold text-base mb-4 border-b border-white/10 pb-2">UK Head Office</h3>
                    <p class="text-xs text-white/50 mb-2 leading-relaxed">
                        <i class="fa-solid fa-location-dot text-accent mr-1.5"></i>
                        38F Chigwell Lane, Oak Hill IND. EST. Loughton. IG10 3NY
                    </p>
                    <p class="text-xs text-white/70 mb-2"><i class="fa-solid fa-phone text-accent mr-1.5"></i> Office: <span class="spec-tag font-bold">0044-1234440530</span></p>
                    <p class="text-xs text-white/70 mb-3"><i class="fa-solid fa-envelope text-accent mr-1.5"></i> Sales@petchemparts.com</p>
                </div>
            </div>

            <div class="border-t border-white/10 mt-10 pt-6 text-center text-xs text-white/40">
                &copy; 2026 | Petchemparts A Brand Unit of Pearlcon Business Services Ltd. UK. All rights reserved.
            </div>
        </div>
    </footer>

    @include('partials.request_modal')

    <script>
        const REQUEST_STORAGE_KEY = 'petchemparts_request_items';

        function toggleMobileMenu(){
            const menu = document.getElementById('mobile-menu');
            if (menu) menu.classList.toggle('hidden');
        }

        function getRequestItems(){
            try { return JSON.parse(localStorage.getItem(REQUEST_STORAGE_KEY)) || []; }
            catch (e) { return []; }
        }

        function saveRequestItems(items){
            localStorage.setItem(REQUEST_STORAGE_KEY, JSON.stringify(items));
            updateBadgeCount();
        }

        function updateBadgeCount(){
            const items = getRequestItems();
            const totalCount = items.reduce((sum, item) => sum + item.quantity, 0);
            const badgeEl = document.getElementById('request-badge-count');
            if (badgeEl) badgeEl.innerText = totalCount;
        }

        function handleHeaderRequestClick(){
            const items = getRequestItems();
            if (items.length === 0) {
                showToast('Your request list is currently empty. Please add products to your list first.', 'warning');
            } else {
                openRequestModal();
            }
        }

        function addToRequest(productId, name, partNumber, price, image, btnElement = null){
            let items = getRequestItems();
            let existing = items.find(i => i.product_id === productId);

            if (existing) { existing.quantity += 1; }
            else { items.push({ product_id: productId, name, part_number: partNumber, price, image, quantity: 1 }); }

            saveRequestItems(items);
            showToast('Product successfully added to your request list!', 'success');

            if (btnElement) {
                const originalHtml = btnElement.innerHTML;
                btnElement.classList.add('!bg-emerald-600');
                btnElement.innerHTML = `<i class="fa-solid fa-check text-xs"></i> <span>Added</span>`;
                setTimeout(() => {
                    btnElement.innerHTML = originalHtml;
                    btnElement.classList.remove('!bg-emerald-600');
                }, 2500);
            }
        }

        function showToast(message, type = 'success'){
            let toast = document.createElement('div');
            if (type === 'warning') {
                toast.className = 'fixed bottom-5 right-5 bg-amber-600 text-white px-5 py-3.5 rounded-xl shadow-2xl z-50 flex items-center gap-3 transition duration-300 border border-amber-400/40 text-xs font-semibold';
                toast.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-amber-200 text-base"></i> ${message}`;
            } else {
                toast.className = 'fixed bottom-5 right-5 bg-[var(--primary)] text-white px-5 py-3.5 rounded-xl shadow-2xl z-50 flex items-center gap-3 transition duration-300 border border-white/10 text-xs font-semibold';
                toast.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-400 text-base"></i> ${message}`;
            }
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        document.addEventListener('DOMContentLoaded', () => { updateBadgeCount(); });
    </script>

    @stack('scripts')
</body>
</html>