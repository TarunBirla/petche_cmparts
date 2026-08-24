@extends('layouts.admin')

@section('title', 'Add New Category')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <h3 class="text-lg font-bold text-slate-900 mb-6">Create Category</h3>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Category Name <span class="text-rose-500">*</span></label>
            <input type="text" name="name" required placeholder="e.g. Industrial Valves, Pressure Transmitters" class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Category Card Image</label>
            <input type="file" name="image" accept="image/*" class="w-full text-xs border rounded-lg border-slate-300 p-2 bg-slate-50">
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded text-sky-600 focus:ring-sky-500 mr-2">
            <label for="is_active" class="text-xs font-semibold text-slate-700">Display / Active on Frontend</label>
        </div>

        <div class="pt-4 border-t flex gap-3">
            <button type="submit" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition">Save Category</button>
            <a href="{{ route('admin.categories.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
