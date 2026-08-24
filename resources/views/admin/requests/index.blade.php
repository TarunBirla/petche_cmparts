@extends('layouts.admin')

@section('title', 'Manage Quote Requests')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Product Quote Requests</h3>
        <p class="text-xs text-slate-500">View incoming quotation inquiries submitted by Petchemparts buyers.</p>
    </div>
</div>

<!-- Filters Bar -->
<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
    <form action="{{ route('admin.requests.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Request #, Customer Name, Email..." class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300">
        </div>

        <div>
            <select name="status" class="w-full text-xs p-2 border rounded-lg border-slate-300 bg-white">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-grow bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs py-2 rounded-lg transition">Filter</button>
            <a href="{{ route('admin.requests.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs px-3 py-2 rounded-lg font-semibold flex items-center justify-center">Reset</a>
        </div>
    </form>
</div>

<!-- Requests Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Request #</th>
                <th class="p-4">Customer Name</th>
                <th class="p-4">Email / Phone</th>
                <th class="p-4">Requested Items</th>
                <th class="p-4">Status</th>
                <th class="p-4">Date Submitted</th>
                <th class="p-4 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($requests as $req)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4 font-mono font-bold text-sky-800 text-sm">
                        #{{ $req->request_number }}
                    </td>
                    <td class="p-4 font-bold text-slate-900">{{ $req->customer_name }}</td>
                    <td class="p-4">
                        <div class="font-medium text-slate-700">{{ $req->customer_email }}</div>
                        <div class="text-[11px] text-slate-400 font-mono">{{ $req->customer_phone }}</div>
                    </td>
                    <td class="p-4 font-bold text-sky-900">{{ $req->items_count }} Item(s)</td>
                    <td class="p-4">
                        <span class="capitalize px-2.5 py-1 rounded-full text-[10px] font-bold 
                            {{ $req->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                            {{ $req->status === 'contacted' ? 'bg-sky-100 text-sky-800' : '' }}
                            {{ $req->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : '' }}
                            {{ $req->status === 'cancelled' ? 'bg-rose-100 text-rose-800' : '' }}">
                            {{ $req->status }}
                        </span>
                    </td>
                    <td class="p-4 text-slate-500 text-[11px]">{{ $req->created_at->format('M d, Y - H:i') }}</td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.requests.show', $req->id) }}" class="bg-sky-600 hover:bg-sky-700 text-white px-3 py-1.5 rounded-lg font-bold transition">View Details</a>
                            <form action="{{ route('admin.requests.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Delete this request entry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-2.5 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400">No quote requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $requests->links() }}</div>
@endsection
