@extends('layouts.admin')

@section('title', 'User Profile & Quote History - ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold text-slate-900">User Profile & Quote History</h3>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Back to Users List
        </a>
    </div>

    <!-- User Profile Header Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-sky-100 text-sky-800 font-extrabold flex items-center justify-center text-2xl shadow-sm flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-extrabold text-slate-900">{{ $user->name }}</h2>
                    @if($user->role === 'admin')
                        <span class="bg-purple-100 text-purple-800 font-bold text-[10px] px-2.5 py-0.5 rounded-full border border-purple-200 uppercase">Admin</span>
                    @else
                        <span class="bg-sky-50 text-sky-700 font-bold text-[10px] px-2.5 py-0.5 rounded-full border border-sky-200 uppercase">Customer Account</span>
                    @endif
                </div>
                <div class="text-xs text-slate-500 mt-1 flex flex-wrap gap-4">
                    <span><i class="fa-solid fa-envelope text-slate-400 mr-1"></i> {{ $user->email }}</span>
                    <span><i class="fa-solid fa-phone text-slate-400 mr-1"></i> {{ $user->phone ?? 'No Phone' }}</span>
                    <span><i class="fa-solid fa-building text-slate-400 mr-1"></i> {{ $user->company_name ?? 'No Company' }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="bg-slate-50 border rounded-xl p-3 text-center flex-1 md:flex-initial">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Quote Requests</span>
                <span class="text-xl font-extrabold text-sky-900">{{ $user->productRequests->count() }}</span>
            </div>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-sky-100 hover:bg-sky-200 text-sky-800 font-bold text-xs px-4 py-3 rounded-xl transition">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit User
            </a>
        </div>
    </div>

    <!-- User Quote Requests History -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h4 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <i class="fa-solid fa-clipboard-list text-sky-600"></i> Quote Requests Submitted by {{ $user->name }}
            </h4>
            <span class="text-xs font-semibold text-slate-500">{{ $user->productRequests->count() }} Submissions</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b">
                    <tr>
                        <th class="p-4">Request #</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Total Items</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($user->productRequests as $req)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4 font-mono font-bold text-sky-900 text-xs">
                                <a href="{{ route('admin.requests.show', $req->id) }}" class="hover:underline">
                                    {{ $req->request_number }}
                                </a>
                            </td>
                            <td class="p-4 text-slate-500 font-mono text-[11px]">
                                {{ $req->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="p-4 font-bold text-slate-800">
                                {{ $req->items_count }} items
                            </td>
                            <td class="p-4">
                                @if($req->status === 'completed')
                                    <span class="bg-emerald-50 text-emerald-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-emerald-200 uppercase">Completed</span>
                                @elseif($req->status === 'contacted')
                                    <span class="bg-sky-50 text-sky-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-sky-200 uppercase">Contacted</span>
                                @elseif($req->status === 'cancelled')
                                    <span class="bg-rose-50 text-rose-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-rose-200 uppercase">Cancelled</span>
                                @else
                                    <span class="bg-amber-50 text-amber-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-amber-200 uppercase">Pending</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.requests.show', $req->id) }}" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition">
                                    View Inquiry Details <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">
                                This user has not submitted any quote requests yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
