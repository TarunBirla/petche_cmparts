<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Petchemparts - Petchemparts Petrochemical & Industrial Parts')</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Swiper CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#b9e5fd',
                            300: '#7cd0fc',
                            400: '#3db6f7',
                            500: '#13a1f3',
                            600: '#13a1f3',
                            700: '#0d85cd',
                            800: '#0a68a1',
                            900: '#074972',
                            950: '#042e48',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Swiper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Swiper Horizontal Flex Fallback Fix */
        .swiper {
            overflow: hidden;
            position: relative;
            width: 100%;
        }
        .swiper-wrapper {
            display: flex !important;
            flex-direction: row !important;
            transition-property: transform;
            box-sizing: content-box;
            width: 100%;
        }
        .swiper-slide {
            flex-shrink: 0 !important;
            position: relative;
            transition-property: transform;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

   

    <!-- Main Navigation Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img class="h-12 w-auto object-contain" src="{{ asset('images/logo.png') }}" alt="Petchemparts Logo">
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex space-x-8 items-center font-medium text-slate-700">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-sky-600 font-semibold' : 'hover:text-sky-600' }} transition">Home</a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-sky-600 font-semibold' : 'hover:text-sky-600' }} transition">All Products</a>
                    <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'text-sky-600 font-semibold' : 'hover:text-sky-600' }} transition">Categories</a>
                    <a href="{{ route('manufacturers.index') }}" class="{{ request()->routeIs('manufacturers.*') ? 'text-sky-600 font-semibold' : 'hover:text-sky-600' }} transition">Manufacturers</a>
                    <a href="{{ route('about-us') }}" class="{{ request()->routeIs('about-us') ? 'text-sky-600 font-semibold' : 'hover:text-sky-600' }} transition">About Us</a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-sky-600 font-semibold' : 'hover:text-sky-600' }} transition">Contact Us</a>
                </nav>

                <!-- Header Actions (Request Button + Mobile Toggle) -->
                <div class="flex items-center gap-3">
                    <button id="open-request-btn" onclick="handleHeaderRequestClick()" class="relative bg-sky-600 hover:bg-sky-700 text-white px-3.5 py-2.5 rounded-lg font-medium shadow-md shadow-sky-200 transition flex items-center gap-2 text-xs sm:text-sm">
                        <i class="fa-solid fa-clipboard-list text-base"></i>
                        <span class="hidden sm:inline">Request List</span>
                        <span id="request-badge-count" class="bg-sky-100 text-sky-800 text-xs font-extrabold px-2 py-0.5 rounded-full ml-0.5">0</span>
                    </button>

                    <!-- Mobile Menu Hamburger Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden text-slate-700 hover:text-sky-600 p-2 text-xl focus:outline-none" aria-label="Toggle Mobile Menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu Drawer -->
        <div id="mobile-menu" class="hidden md:hidden bg-slate-900 text-slate-200 border-t border-slate-800 px-4 py-4 space-y-2 text-sm font-medium">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-sky-600 text-white font-bold' : 'hover:bg-slate-800' }}">Home</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('products.*') ? 'bg-sky-600 text-white font-bold' : 'hover:bg-slate-800' }}">All Products</a>
            <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('categories.*') ? 'bg-sky-600 text-white font-bold' : 'hover:bg-slate-800' }}">Categories</a>
            <a href="{{ route('manufacturers.index') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('manufacturers.*') ? 'bg-sky-600 text-white font-bold' : 'hover:bg-slate-800' }}">Manufacturers</a>
            <a href="{{ route('about-us') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('about-us') ? 'bg-sky-600 text-white font-bold' : 'hover:bg-slate-800' }}">About Us</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('contact') ? 'bg-sky-600 text-white font-bold' : 'hover:bg-slate-800' }}">Contact Us</a>
        </div>
    </header>

    <!-- Global Header Search Bar (On Every Page Except Products Catalog Page & Home Page) -->
    @if(!request()->routeIs('products.index') && !request()->routeIs('home'))
        <div class="bg-slate-900 border-b border-slate-800 py-3 px-4 shadow-md">
            <div class="max-w-7xl mx-auto">
                <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2">
                    <div class="relative w-full sm:flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Product Name, Part # or Model #..." class="w-full text-xs pl-9 pr-4 py-2.5 rounded-xl bg-slate-800 text-white placeholder-slate-400 border border-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium">
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="manufacturer" class="w-full text-xs px-3 py-2.5 rounded-xl bg-slate-800 text-white border border-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium">
                            <option value="">All Manufacturers</option>
                            @foreach(\App\Models\Manufacturer::where('is_active', true)->orderBy('name')->get() as $manuf)
                                <option value="{{ $manuf->slug }}" {{ request('manufacturer') == $manuf->slug ? 'selected' : '' }}>{{ $manuf->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold px-6 py-2.5 rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-sky-950">
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
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded shadow-sm flex justify-between items-center">
                    <div><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold">&times;</button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 mt-16 border-t-4 border-sky-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img class="h-10 w-auto bg-white p-1 rounded" src="{{ asset('images/logo.png') }}" alt="Petchemparts">
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed mb-3">
                        UK's leading Petrochemical, industrial, oil and gas spare parts, consumable & MRO reseller globally.
                    </p>
                    <div class="text-[11px] text-sky-400 font-semibold">
                        <i class="fa-solid fa-clock mr-1"></i> 7 Days a week: 9:00 am - 7:00 pm
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-semibold text-base mb-4 border-b border-slate-800 pb-2">Information Links</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('about-us') }}" class="hover:text-sky-400 transition"><i class="fa-solid fa-chevron-right text-[10px] text-sky-500 mr-2"></i>About Us</a></li>
                        <li><a href="{{ route('delivery') }}" class="hover:text-sky-400 transition"><i class="fa-solid fa-chevron-right text-[10px] text-sky-500 mr-2"></i>Delivery and Returns</a></li>
                        <li><a href="{{ route('terms-and-conditions') }}" class="hover:text-sky-400 transition"><i class="fa-solid fa-chevron-right text-[10px] text-sky-500 mr-2"></i>Terms and Conditions</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-sky-400 transition"><i class="fa-solid fa-chevron-right text-[10px] text-sky-500 mr-2"></i>Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold text-base mb-4 border-b border-slate-800 pb-2">Product Catalog</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('products.index') }}" class="hover:text-sky-400 transition"><i class="fa-solid fa-chevron-right text-[10px] text-sky-500 mr-2"></i>All Products</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-sky-400 transition"><i class="fa-solid fa-chevron-right text-[10px] text-sky-500 mr-2"></i>Product Categories</a></li>
                        <li><a href="{{ route('manufacturers.index') }}" class="hover:text-sky-400 transition"><i class="fa-solid fa-chevron-right text-[10px] text-sky-500 mr-2"></i>OEM Manufacturers</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-semibold text-base mb-4 border-b border-slate-800 pb-2">UK Head Office</h3>
                    <p class="text-xs text-slate-400 mb-2 leading-relaxed">
                        <i class="fa-solid fa-location-dot text-sky-400 mr-1.5"></i>
                        Suite 211 Sterling House, Langston Road, Loughton IG10 3TS, United Kingdom
                    </p>
                    <p class="text-xs text-slate-300 mb-1"><i class="fa-solid fa-phone text-sky-400 mr-1.5"></i> Helpline: <span class="font-mono font-bold">0044-7891363776</span></p>
                    <p class="text-xs text-slate-300 mb-2"><i class="fa-solid fa-phone text-sky-400 mr-1.5"></i> Office: <span class="font-mono font-bold">0044-1234440530</span></p>
                    <p class="text-xs text-slate-300 mb-3"><i class="fa-solid fa-envelope text-sky-400 mr-1.5"></i> Sales@petchemparts.com</p>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-10 pt-6 text-center text-xs text-slate-400">
                &copy; 2023 | Petchemparts A Brand Unit of Pearlcon Business Services Ltd. UK. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Request Modal Partial -->
    @include('partials.request_modal')

    <!-- Global Client JS for Request System -->
    <script>
        const REQUEST_STORAGE_KEY = 'petchemparts_request_items';

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu) menu.classList.toggle('hidden');
        }

        function getRequestItems() {
            try {
                return JSON.parse(localStorage.getItem(REQUEST_STORAGE_KEY)) || [];
            } catch (e) {
                return [];
            }
        }

        function saveRequestItems(items) {
            localStorage.setItem(REQUEST_STORAGE_KEY, JSON.stringify(items));
            updateBadgeCount();
        }

        function updateBadgeCount() {
            const items = getRequestItems();
            const totalCount = items.reduce((sum, item) => sum + item.quantity, 0);
            const badgeEl = document.getElementById('request-badge-count');
            if (badgeEl) {
                badgeEl.innerText = totalCount;
            }
        }

        function handleHeaderRequestClick() {
            const items = getRequestItems();
            if (items.length === 0) {
                showToast('Your request list is currently empty. Please add products to your list first.', 'warning');
            } else {
                openRequestModal();
            }
        }

        function addToRequest(productId, name, partNumber, price, image, btnElement = null) {
            let items = getRequestItems();
            let existing = items.find(i => i.product_id === productId);

            if (existing) {
                existing.quantity += 1;
            } else {
                items.push({
                    product_id: productId,
                    name: name,
                    part_number: partNumber,
                    price: price,
                    image: image,
                    quantity: 1
                });
            }

            saveRequestItems(items);
            showToast('Product successfully added to your request list!', 'success');

            // Update Button State to 'Added'
            if (btnElement) {
                const originalHtml = btnElement.innerHTML;
                btnElement.className = btnElement.className.replace('bg-sky-600 hover:bg-sky-700', 'bg-emerald-600 hover:bg-emerald-700');
                btnElement.innerHTML = `<i class="fa-solid fa-check text-xs"></i> <span>Added</span>`;
                setTimeout(() => {
                    btnElement.innerHTML = originalHtml;
                    btnElement.className = btnElement.className.replace('bg-emerald-600 hover:bg-emerald-700', 'bg-sky-600 hover:bg-sky-700');
                }, 2500);
            }
        }

        function showToast(message, type = 'success') {
            let toast = document.createElement('div');
            if (type === 'warning') {
                toast.className = 'fixed bottom-5 right-5 bg-amber-600 text-white px-5 py-3.5 rounded-xl shadow-2xl z-50 flex items-center gap-3 transition duration-300 transform translate-y-0 border border-amber-400/40 text-xs font-semibold';
                toast.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-amber-200 text-base"></i> ${message}`;
            } else {
                toast.className = 'fixed bottom-5 right-5 bg-sky-900 text-white px-5 py-3.5 rounded-xl shadow-2xl z-50 flex items-center gap-3 transition duration-300 transform translate-y-0 border border-sky-700 text-xs font-semibold';
                toast.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-400 text-base"></i> ${message}`;
            }
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateBadgeCount();
        });
    </script>

    @stack('scripts')
</body>
</html>
