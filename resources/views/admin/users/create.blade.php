@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-slate-900">Add New User Account</h3>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-slate-500 hover:text-slate-800 font-semibold">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Users List
        </a>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs mb-6">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Full Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+44 7123 456789" class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Company / Organization</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Account Role <span class="text-rose-500">*</span></label>
                <select name="role" required class="w-full text-xs p-2 border rounded-lg border-slate-300 bg-white">
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer (Frontend User)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Full Access)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required placeholder="Minimum 6 characters" class="w-full text-xs px-3 py-2 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
            </div>
        </div>

        <div class="pt-4 border-t flex gap-3">
            <button type="submit" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition">Create User Account</button>
            <a href="{{ route('admin.users.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
