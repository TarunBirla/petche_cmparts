@extends('layouts.admin')

@section('title', 'Edit CMS Page: ' . $page->title)

@section('content')
<div class="max-w-4xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <h3 class="text-lg font-bold text-slate-900 mb-6">Edit Page: {{ $page->title }}</h3>

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Page Title <span class="text-rose-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">URL Slug</label>
            <input type="text" value="{{ $page->slug }}" disabled class="w-full text-xs px-3 py-2 border rounded-lg border-slate-200 bg-slate-100 font-mono text-slate-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Page Content (HTML / Text) <span class="text-rose-500">*</span></label>
            <textarea name="content" rows="14" required class="w-full text-xs p-3 border rounded-lg border-slate-300 font-mono leading-relaxed">{{ old('content', $page->content) }}</textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $page->is_active ? 'checked' : '' }} class="rounded text-sky-600 focus:ring-sky-500 mr-2">
            <label for="is_active" class="text-xs font-semibold text-slate-700">Display / Active on Frontend</label>
        </div>

        <div class="pt-4 border-t flex gap-3">
            <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition">Update Page Content</button>
            <a href="{{ route('admin.pages.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
