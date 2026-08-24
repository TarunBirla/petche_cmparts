<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Petchemparts</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Tailwind CSS CDN -->
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
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0F6B66;
            --primary-dark: #0A4744;
            --primary-light: #E7F4F3;
            --accent: #F2A541;
            --accent-dark: #C8811F;
            --bg: #F6F8FA;
            --surface: #FFFFFF;
            --text: #101828;
            --text-muted: #5B6472;
            --border: #E1E6EB;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text); }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F6F8FA] text-slate-800 flex min-h-screen">

    <!-- Admin Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col justify-between border-r border-slate-800">
        <div>
            <!-- Sidebar Header / Logo -->
            <div class="h-20 bg-[#0A4744] flex items-center px-6 border-b border-slate-800 gap-3">
                <img class="h-9 w-auto bg-white p-1 rounded" src="{{ asset('images/logo.png') }}" alt="Petchemparts Logo">
                <span class="font-extrabold text-white text-base tracking-wide">Admin Panel</span>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 font-medium text-xs">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-3 rounded-xl transition">
                    <i class="fa-solid fa-chart-line text-sm w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <div class="pt-3 pb-1 px-4 text-[10px] uppercase font-bold tracking-wider text-slate-500">Catalog Management</div>

                <a href="{{ route('admin.manufacturers.index') }}" class="{{ request()->routeIs('admin.manufacturers.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-building-flag text-sm w-5 text-center"></i>
                    <span>Manufacturers</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-layer-group text-sm w-5 text-center"></i>
                    <span>Categories</span>
                </a>

                <a href="{{ route('admin.subcategories.index') }}" class="{{ request()->routeIs('admin.subcategories.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-sitemap text-sm w-5 text-center"></i>
                    <span>Sub-Categories</span>
                </a>

                <a href="{{ route('admin.pdfs.index') }}" class="{{ request()->routeIs('admin.pdfs.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-file-pdf text-sm w-5 text-center"></i>
                    <span>PDF Module</span>
                </a>

                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-boxes-stacked text-sm w-5 text-center"></i>
                    <span>Products</span>
                </a>

                <div class="pt-3 pb-1 px-4 text-[10px] uppercase font-bold tracking-wider text-slate-500">Inquiries & Content</div>

                <a href="{{ route('admin.requests.index') }}" class="{{ request()->routeIs('admin.requests.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-clipboard-list text-sm w-5 text-center"></i>
                    <span>Product Requests</span>
                </a>

                <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-file-lines text-sm w-5 text-center"></i>
                    <span>CMS Pages</span>
                </a>

                <a href="{{ route('admin.contact-messages.index') }}" class="{{ request()->routeIs('admin.contact-messages.*') ? 'bg-[#0F6B66] text-white font-semibold shadow-md' : 'hover:bg-slate-800 text-slate-300' }} flex items-center gap-3 px-4 py-2.5 rounded-xl transition">
                    <i class="fa-solid fa-envelope-open-text text-sm w-5 text-center"></i>
                    <span>Contact Messages</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800">
            <a href="{{ route('home') }}" target="_blank" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs py-2 rounded-lg font-medium transition flex items-center justify-center gap-2 mb-2">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>View Frontend Site</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-rose-600/20 hover:bg-rose-600 text-rose-300 hover:text-white text-xs py-2 rounded-lg font-medium transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        
        <!-- Admin Top Navigation Bar -->
        <header class="bg-white border-b border-slate-200 h-20 px-8 flex justify-between items-center sticky top-0 z-30">
            <div>
                <h2 class="text-xl font-bold text-slate-900">@yield('title', 'Admin Dashboard')</h2>
                <p class="text-xs text-slate-500">Petchemparts Administration</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-sky-50 px-3 py-1.5 rounded-full border border-sky-100">
                    <i class="fa-solid fa-user-circle text-sky-600 text-base"></i>
                    <span>{{ auth()->user()->name ?? 'Admin User' }}</span>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-8 flex-grow">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm mb-6 flex justify-between items-center text-xs font-medium">
                    <div><i class="fa-solid fa-circle-check text-base mr-2 text-emerald-600"></i> {{ session('success') }}</div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-700 font-bold">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl shadow-sm mb-6 flex justify-between items-center text-xs font-medium">
                    <div><i class="fa-solid fa-circle-exclamation text-base mr-2 text-rose-600"></i> {{ session('error') }}</div>
                    <button onclick="this.parentElement.remove()" class="text-rose-700 font-bold">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
