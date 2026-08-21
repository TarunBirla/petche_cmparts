@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Products</span>
            <span class="text-3xl font-extrabold text-slate-900">{{ $totalProducts }}</span>
        </div>
        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Requests</span>
            <span class="text-3xl font-extrabold text-slate-900">{{ $totalRequests }}</span>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Pending Inquiries</span>
            <span class="text-3xl font-extrabold text-amber-600">{{ $pendingRequests }}</span>
        </div>
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Manufacturers</span>
            <span class="text-3xl font-extrabold text-slate-900">{{ $totalManufacturers }}</span>
        </div>
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-building-flag"></i>
        </div>
    </div>

</div>

<!-- Recent Inquiries & Latest Products -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- Recent Requests -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-slate-900 text-base">Recent Quote Requests</h3>
            <a href="{{ route('admin.requests.index') }}" class="text-xs font-semibold text-sky-600 hover:underline">View All</a>
        </div>

        @if($recentRequests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b">
                        <tr>
                            <th class="p-3">Req #</th>
                            <th class="p-3">Customer</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentRequests as $req)
                            <tr>
                                <td class="p-3 font-mono font-bold text-sky-800">{{ $req->request_number }}</td>
                                <td class="p-3">
                                    <div class="font-bold text-slate-800">{{ $req->customer_name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $req->customer_email }}</div>
                                </td>
                                <td class="p-3">
                                    <span class="capitalize px-2 py-0.5 rounded-full text-[10px] font-bold 
                                        {{ $req->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $req->status === 'contacted' ? 'bg-sky-100 text-sky-800' : '' }}
                                        {{ $req->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $req->status === 'cancelled' ? 'bg-rose-100 text-rose-800' : '' }}">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.requests.show', $req->id) }}" class="bg-sky-50 text-sky-700 hover:bg-sky-100 px-2.5 py-1 rounded font-semibold text-[11px]">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-xs text-slate-500 py-6 text-center">No quote requests received yet.</p>
        @endif
    </div>

    <!-- Latest Products -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-slate-900 text-base">Latest Added Products</h3>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-sky-600 hover:underline">View Catalog</a>
        </div>

        @if($latestProducts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b">
                        <tr>
                            <th class="p-3">Product Name</th>
                            <th class="p-3">Brand</th>
                            <th class="p-3">Price (£)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($latestProducts as $prod)
                            <tr>
                                <td class="p-3 font-semibold text-slate-800 line-clamp-1 max-w-[200px]">{{ $prod->name }}</td>
                                <td class="p-3 text-slate-600">{{ $prod->manufacturer->name ?? 'N/A' }}</td>
                                <td class="p-3 font-bold text-sky-900">£{{ number_format($prod->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-xs text-slate-500 py-6 text-center">No products added yet.</p>
        @endif
    </div>

</div>

@endsection
