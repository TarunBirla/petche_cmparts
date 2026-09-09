@extends('layouts.admin')

@section('title', 'Edit CMS Page: ' . $page->title)

@push('styles')
<!-- Summernote Lite CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor {
        border-radius: 0.75rem !important;
        overflow: hidden;
        border-color: #CBD5E1 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .note-toolbar {
        background-color: #F8FAFC !important;
        border-bottom-color: #E2E8F0 !important;
        padding: 6px 10px !important;
    }
    .note-btn {
        border-radius: 0.375rem !important;
        background: #ffffff !important;
        border: 1px solid #E2E8F0 !important;
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
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
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Page Content <span class="text-rose-500">*</span></label>
            <textarea id="page-content-editor" name="content" rows="14" required class="w-full text-xs p-3 border rounded-lg border-slate-300 font-mono leading-relaxed">{{ old('content', $page->content) }}</textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $page->is_active ? 'checked' : '' }} class="rounded text-sky-600 focus:ring-sky-500 mr-2">
            <label for="is_active" class="text-xs font-semibold text-slate-700">Display / Active on Frontend</label>
        </div>

        <div class="pt-4 border-t flex gap-3">
            <button type="submit" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition">Update Page Content</button>
            <a href="{{ route('admin.pages.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#page-content-editor').summernote({
            placeholder: 'Write page content here with rich formatting...',
            tabsize: 2,
            height: 420,
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
