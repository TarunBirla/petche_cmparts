@extends('layouts.admin')

@section('title', 'Users & Customers Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-900">User Accounts & Customers</h3>
            <p class="text-xs text-slate-500">Manage registered customers, administrators, and track quote request activity.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Add New User</span>
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-3">
        <form action="{{ route('admin.users.index') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-3">
            <div class="relative w-full sm:flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Name, Email, Phone, Company..." class="w-full text-xs pl-8 pr-3 py-2 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
                <i class="fa-solid fa-search absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
            </div>
            
            <div class="w-full sm:w-44">
                <select name="role" onchange="this.form.submit()" class="w-full text-xs p-2 border rounded-lg border-slate-300 bg-white">
                    <option value="">All Roles</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customers</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrators</option>
                </select>
            </div>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-4 py-2 rounded-lg transition w-full sm:w-auto">Filter</button>
            @if(request()->anyFilled(['search', 'role']))
                <a href="{{ route('admin.users.index') }}" class="text-xs text-rose-600 font-semibold hover:underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b">
                    <tr>
                        <th class="p-4">User Details</th>
                        <th class="p-4">Phone & Company</th>
                        <th class="p-4">Role</th>
                        <th class="p-4 text-center">Quote Requests</th>
                        <th class="p-4">Joined Date</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-sky-100 text-sky-800 font-bold flex items-center justify-center text-sm shadow-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="font-bold text-slate-900 hover:text-sky-600 text-sm block">
                                            {{ $user->name }}
                                        </a>
                                        <span class="text-slate-400 font-mono text-[11px]">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ $user->phone ?? 'N/A' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $user->company_name ?? 'Individual' }}</div>
                            </td>
                            <td class="p-4">
                                @if($user->role === 'admin')
                                    <span class="bg-purple-100 text-purple-800 font-extrabold text-[10px] px-2.5 py-0.5 rounded-full border border-purple-200">
                                        <i class="fa-solid fa-shield-halved mr-1"></i> Admin
                                    </span>
                                @else
                                    <span class="bg-sky-50 text-sky-700 font-bold text-[10px] px-2.5 py-0.5 rounded-full border border-sky-200">
                                        Customer
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-extrabold text-xs px-3 py-1 rounded-full border border-emerald-200 transition">
                                    <i class="fa-solid fa-file-invoice text-[10px]"></i>
                                    <span>{{ $user->product_requests_count }} Requests</span>
                                </a>
                            </td>
                            <td class="p-4 text-slate-400 font-mono text-[11px]">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg inline-block shadow-sm transition" title="View Profile & Requests">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-1.5 bg-sky-100 hover:bg-sky-200 text-sky-800 rounded-lg inline-block shadow-sm transition" title="Edit User">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white rounded-lg transition" title="Delete User">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                No user accounts found matching your query.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
