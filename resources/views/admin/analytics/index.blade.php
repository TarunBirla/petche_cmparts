@extends('layouts.admin')

@section('title', 'Page Visit Analytics')

@section('content')

<!-- Top Summary Stat Cards Grid (6 Cards) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-8">
    
    <!-- Total Visits -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Visits</span>
            <span class="text-2xl font-extrabold text-slate-900">{{ number_format($totalVisits) }}</span>
        </div>
        <div class="w-11 h-11 bg-[var(--primary-light)] text-[var(--primary-dark)] rounded-2xl flex items-center justify-center text-lg shadow-sm">
            <i class="fa-solid fa-chart-line"></i>
        </div>
    </div>

    <!-- Today's Visits -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Today's Visits</span>
            <span class="text-2xl font-extrabold text-[var(--primary-dark)]">{{ number_format($todaysVisits) }}</span>
        </div>
        <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-lg shadow-sm">
            <i class="fa-solid fa-calendar-day"></i>
        </div>
    </div>

    <!-- Registered Users -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Registered Users</span>
            <span class="text-2xl font-extrabold text-slate-900">{{ number_format($registeredUsers) }}</span>
        </div>
        <div class="w-11 h-11 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-lg shadow-sm">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Manufacturers Listed -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Manufacturers</span>
            <span class="text-2xl font-extrabold text-slate-900">{{ number_format($totalManufacturers) }}</span>
        </div>
        <div class="w-11 h-11 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-lg shadow-sm">
            <i class="fa-solid fa-building-flag"></i>
        </div>
    </div>

    <!-- Products Listed -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Products Listed</span>
            <span class="text-2xl font-extrabold text-slate-900">{{ number_format($totalProducts) }}</span>
        </div>
        <div class="w-11 h-11 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-lg shadow-sm">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
    </div>

    <!-- Unique Countries -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Countries</span>
            <span class="text-2xl font-extrabold text-indigo-600">{{ number_format($countriesCount) }}</span>
        </div>
        <div class="w-11 h-11 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-lg shadow-sm">
            <i class="fa-solid fa-earth-americas"></i>
        </div>
    </div>

</div>

<!-- Charts Section Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    
    <!-- Last 30 Days Visits Line Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Last 30 Days Visits</h3>
                <p class="text-xs text-slate-500">Daily website page visit trends</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[var(--primary-light)] text-[var(--primary-dark)] border border-[var(--primary)]/20">
                <i class="fa-solid fa-chart-area mr-1"></i> Real-time Tracking
            </span>
        </div>
        <div class="h-72">
            <canvas id="visitsLineChart"></canvas>
        </div>
    </div>

    <!-- Browser Usage & Platform Column -->
    <div class="space-y-8">
        
        <!-- Browser Usage Pie Chart -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 text-base mb-1">Browser Usage</h3>
            <p class="text-xs text-slate-500 mb-4">Distribution by user browser</p>
            <div class="h-52 relative flex justify-center">
                <canvas id="browserPieChart"></canvas>
            </div>
        </div>

        <!-- Platform Usage Doughnut Chart -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 text-base mb-1">Platform Usage</h3>
            <p class="text-xs text-slate-500 mb-4">Operating systems & devices</p>
            <div class="h-52 relative flex justify-center">
                <canvas id="platformDoughnutChart"></canvas>
            </div>
        </div>

    </div>

</div>

<!-- Top Visited Pages List -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
    <h3 class="font-bold text-slate-900 text-base mb-1">Top Visited Pages</h3>
    <p class="text-xs text-slate-500 mb-6">Most viewed catalog & landing pages on Sparelyx</p>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($topPages as $top)
            <div class="p-4 rounded-xl border border-slate-100 bg-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[var(--primary-light)] text-[var(--primary-dark)] flex items-center justify-center font-bold text-xs">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <span class="font-bold text-slate-800 text-xs block">{{ $top->page_name }}</span>
                        <span class="text-[10px] text-slate-400">Page Type</span>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-sm font-extrabold text-[var(--primary-dark)] block">{{ number_format($top->total) }}</span>
                    <span class="text-[10px] text-slate-400">visits</span>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-500 col-span-3 text-center py-4">No visit metrics captured yet.</p>
        @endforelse
    </div>
</div>

<!-- PAGE VISIT HISTORY TABLE SECTION -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    
    <!-- Table Header & Controls Bar -->
    <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-900 text-base">Page Visit History</h3>
            <p class="text-xs text-slate-500">Real-time log of user views, part inquiries & RFQ actions</p>
        </div>

        <!-- Filter & Search Controls -->
        <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex flex-wrap items-center gap-3">
            
            <!-- Page Type Filter -->
            <select name="page_filter" onchange="this.form.submit()" class="text-xs border border-slate-300 rounded-xl px-3 py-2 bg-slate-50 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-[var(--primary)]">
                <option value="">All Page Types</option>
                <option value="Home" {{ request('page_filter') == 'Home' ? 'selected' : '' }}>Home</option>
                <option value="All Products" {{ request('page_filter') == 'All Products' ? 'selected' : '' }}>All Products</option>
                <option value="Product View" {{ request('page_filter') == 'Product View' ? 'selected' : '' }}>Product View</option>
                <option value="Categories" {{ request('page_filter') == 'Categories' ? 'selected' : '' }}>Categories</option>
                <option value="Manufacturers" {{ request('page_filter') == 'Manufacturers' ? 'selected' : '' }}>Manufacturers</option>
                <option value="About Us" {{ request('page_filter') == 'About Us' ? 'selected' : '' }}>About Us</option>
                <option value="Contact Us" {{ request('page_filter') == 'Contact Us' ? 'selected' : '' }}>Contact Us</option>
                <option value="Search Results" {{ request('page_filter') == 'Search Results' ? 'selected' : '' }}>Search Results</option>
                <option value="Request Quote" {{ request('page_filter') == 'Request Quote' ? 'selected' : '' }}>Request Quote</option>
                <option value="Quote Submission" {{ request('page_filter') == 'Quote Submission' ? 'selected' : '' }}>Quote Submission</option>
            </select>

            <!-- Search Input -->
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search User, IP, Part #, RFQ..." class="text-xs border border-slate-300 rounded-xl pl-8 pr-3 py-2 bg-slate-50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-[var(--primary)] w-60">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>

            @if(request()->hasAny(['search', 'page_filter']))
                <a href="{{ route('admin.analytics.index') }}" class="text-xs text-rose-600 hover:underline font-semibold">Clear</a>
            @endif
        </form>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-[10px] tracking-wider border-b border-slate-200">
                <tr>
                    <th class="py-3.5 px-4">ID</th>
                    <th class="py-3.5 px-4">User</th>
                    <th class="py-3.5 px-4">Manufacturer</th>
                    <th class="py-3.5 px-4">Page</th>
                    <th class="py-3.5 px-4">Product (Part #)</th>
                    <th class="py-3.5 px-4">Quote Request ID</th>
                    <th class="py-3.5 px-4">IP</th>
                    <th class="py-3.5 px-4">Location</th>
                    <th class="py-3.5 px-4">Browser</th>
                    <th class="py-3.5 px-4">Platform</th>
                    <th class="py-3.5 px-4">
                        <span class="inline-flex items-center gap-1 text-[var(--primary-dark)] font-bold cursor-pointer">
                            Date <i class="fa-solid fa-arrow-down-short-wide text-[10px]"></i>
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                @forelse($pageVisits as $visit)
                    <tr class="hover:bg-slate-50/80 transition">
                        <!-- ID -->
                        <td class="py-3.5 px-4 font-mono text-slate-400 text-[11px]">#{{ $visit->id }}</td>
                        
                        <!-- User -->
                        <td class="py-3.5 px-4">
                            @if($visit->user_id)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[var(--primary-light)] text-[var(--primary-dark)] border border-[var(--primary)]/20">
                                    <i class="fa-solid fa-user text-[10px]"></i> {{ $visit->user_name }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600">
                                    Guest
                                </span>
                            @endif
                        </td>

                        <!-- Manufacturer -->
                        <td class="py-3.5 px-4">
                            @if($visit->manufacturer_name)
                                <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-building text-[10px] text-purple-500"></i> {{ $visit->manufacturer_name }}
                                </span>
                            @else
                                <span class="text-slate-300 font-normal">—</span>
                            @endif
                        </td>

                        <!-- Page -->
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold inline-block
                                {{ $visit->page_name === 'Product View' ? 'bg-amber-50 text-amber-800 border border-amber-200' : '' }}
                                {{ $visit->page_name === 'Quote Submission' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : '' }}
                                {{ $visit->page_name === 'Request Quote' ? 'bg-sky-50 text-sky-800 border border-sky-200' : '' }}
                                {{ !in_array($visit->page_name, ['Product View', 'Quote Submission', 'Request Quote']) ? 'bg-slate-100 text-slate-700' : '' }}">
                                {{ $visit->page_name }}
                            </span>
                        </td>

                        <!-- Product (Part #) -->
                        <td class="py-3.5 px-4">
                            @if($visit->product_title)
                                <span class="font-semibold text-slate-900 max-w-[220px] truncate block" title="{{ $visit->product_title }}">
                                    <i class="fa-solid fa-microchip text-[10px] text-[var(--primary-dark)] mr-1"></i>{{ $visit->product_title }}
                                </span>
                            @else
                                <span class="text-slate-300 font-normal">—</span>
                            @endif
                        </td>

                        <!-- Quote Request ID -->
                        <td class="py-3.5 px-4">
                            @if($visit->quote_request_id)
                                <span class="font-mono font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 text-[11px]">
                                    {{ $visit->quote_request_id }}
                                </span>
                            @else
                                <span class="text-slate-300 font-normal">—</span>
                            @endif
                        </td>

                        <!-- IP -->
                        <td class="py-3.5 px-4 font-mono text-[11px] text-slate-600">{{ $visit->ip }}</td>

                        <!-- Location (Resolved via ip-api.com) -->
                        <td class="py-3.5 px-4">
                            @php $loc = $visit->location; @endphp
                            @if($loc && $loc !== '—')
                                <span class="inline-flex items-center gap-1 text-[11px] text-slate-700 font-medium">
                                    <i class="fa-solid fa-location-dot text-rose-500 text-[10px]"></i> {{ $loc }}
                                </span>
                            @else
                                <span class="text-slate-300 font-normal">—</span>
                            @endif
                        </td>

                        <!-- Browser -->
                        <td class="py-3.5 px-4">
                            <span class="text-[11px] text-slate-600 flex items-center gap-1.5">
                                @if(str_contains($visit->browser, 'Chrome'))
                                    <i class="fa-brands fa-chrome text-amber-500"></i>
                                @elseif(str_contains($visit->browser, 'Safari'))
                                    <i class="fa-brands fa-safari text-sky-500"></i>
                                @elseif(str_contains($visit->browser, 'Firefox'))
                                    <i class="fa-brands fa-firefox-browser text-orange-500"></i>
                                @elseif(str_contains($visit->browser, 'Edge'))
                                    <i class="fa-brands fa-edge text-blue-600"></i>
                                @else
                                    <i class="fa-solid fa-globe text-slate-400"></i>
                                @endif
                                {{ $visit->browser }}
                            </span>
                        </td>

                        <!-- Platform -->
                        <td class="py-3.5 px-4">
                            <span class="text-[11px] text-slate-600 flex items-center gap-1.5">
                                @if(str_contains($visit->platform, 'Windows'))
                                    <i class="fa-brands fa-windows text-sky-500"></i>
                                @elseif(str_contains($visit->platform, 'Mac') || str_contains($visit->platform, 'iOS'))
                                    <i class="fa-brands fa-apple text-slate-800"></i>
                                @elseif(str_contains($visit->platform, 'Linux'))
                                    <i class="fa-brands fa-linux text-amber-600"></i>
                                @elseif(str_contains($visit->platform, 'Android'))
                                    <i class="fa-brands fa-android text-emerald-500"></i>
                                @else
                                    <i class="fa-solid fa-desktop text-slate-400"></i>
                                @endif
                                {{ $visit->platform }}
                            </span>
                        </td>

                        <!-- Date -->
                        <td class="py-3.5 px-4 text-slate-500 text-[11px] whitespace-nowrap">
                            {{ $visit->created_at->format('M d, Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-10 text-slate-400 text-xs">
                            <i class="fa-solid fa-inbox text-3xl mb-2 block text-slate-300"></i>
                            No page visit records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
        <div class="text-slate-500 font-medium">
            Showing <span class="font-bold text-slate-800">{{ $pageVisits->firstItem() ?? 0 }}</span> to <span class="font-bold text-slate-800">{{ $pageVisits->lastItem() ?? 0 }}</span> of <span class="font-bold text-slate-800">{{ $pageVisits->total() }}</span> results
        </div>
        <div>
            {{ $pageVisits->links() }}
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Last 30 Days Visits Line Chart
        const lineCtx = document.getElementById('visitsLineChart');
        if (lineCtx) {
            const chartDates = @json($chartDates);
            const chartVisits = @json($chartVisits);

            const gradient = lineCtx.getContext('2d').createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(112, 181, 62, 0.35)');
            gradient.addColorStop(1, 'rgba(112, 181, 62, 0.0)');

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: chartDates,
                    datasets: [{
                        label: 'Visits',
                        data: chartVisits,
                        borderColor: '#70B53E',
                        borderWidth: 2.5,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4F8A28',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 10,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 10 }, color: '#94A3B8' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F1F5F9' },
                            ticks: { precision: 0, font: { family: 'Inter', size: 10 }, color: '#94A3B8' }
                        }
                    }
                }
            });
        }

        // 2. Browser Usage Pie Chart
        const browserCtx = document.getElementById('browserPieChart');
        if (browserCtx) {
            const browserData = @json($browserData);
            const labels = browserData.map(item => item.browser);
            const totals = browserData.map(item => item.total);

            new Chart(browserCtx, {
                type: 'pie',
                data: {
                    labels: labels.length ? labels : ['No Data'],
                    datasets: [{
                        data: totals.length ? totals : [1],
                        backgroundColor: [
                            '#F59E0B',
                            '#0EA5E9',
                            '#F97316',
                            '#2563EB',
                            '#10B981',
                            '#64748B'
                        ],
                        borderWidth: 2,
                        borderColor: '#FFFFFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { family: 'Inter', size: 10 }, boxWidth: 12, padding: 12 }
                        }
                    }
                }
            });
        }

        // 3. Platform Usage Doughnut Chart
        const platformCtx = document.getElementById('platformDoughnutChart');
        if (platformCtx) {
            const platformData = @json($platformData);
            const labels = platformData.map(item => item.platform);
            const totals = platformData.map(item => item.total);

            new Chart(platformCtx, {
                type: 'doughnut',
                data: {
                    labels: labels.length ? labels : ['No Data'],
                    datasets: [{
                        data: totals.length ? totals : [1],
                        backgroundColor: [
                            '#3B82F6',
                            '#1E293B',
                            '#D97706',
                            '#10B981',
                            '#8B5CF6'
                        ],
                        borderWidth: 2,
                        borderColor: '#FFFFFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { family: 'Inter', size: 10 }, boxWidth: 12, padding: 12 }
                        }
                    }
                }
            });
        }

    });
</script>
@endpush
