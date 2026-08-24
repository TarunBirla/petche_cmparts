@extends('layouts.admin')

@section('title', 'Upload PDF Document')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <h3 class="text-lg font-bold text-slate-900 mb-6">Upload New PDF Document</h3>

    <form action="{{ route('admin.pdfs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Document Title <span class="text-rose-500">*</span></label>
            <input type="text" name="title" required placeholder="e.g. Fisher 667 Control Valve Technical Specs" class="w-full text-xs px-3 py-2.5 border rounded-lg border-slate-300 focus:ring-2 focus:ring-sky-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">PDF File (.pdf) <span class="text-rose-500">*</span></label>
            <input type="file" name="pdf_file" accept=".pdf,application/pdf" required class="w-full text-xs border rounded-lg border-slate-300 p-2 bg-slate-50">
            <p class="text-[11px] text-slate-400 mt-1">Maximum file size: 10 MB</p>
        </div>

        <div class="pt-4 border-t flex gap-3">
            <button type="submit" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition">Upload PDF Document</button>
            <a href="{{ route('admin.pdfs.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
