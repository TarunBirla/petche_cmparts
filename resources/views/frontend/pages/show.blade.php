@extends('layouts.app')

@section('title', $page->title . ' - Petchemparts')

@push('styles')
<style>
    .cms-content { font-size: 0.875rem; color: #334155; line-height: 1.7; }
    .cms-content h1 { font-size: 1.5rem; font-weight: 800; color: #0F172A; margin-top: 1.5rem; margin-bottom: 0.75rem; }
    .cms-content h2 { font-size: 1.35rem; font-weight: 700; color: #0F172A; margin-top: 1.25rem; margin-bottom: 0.625rem; }
    .cms-content h3 { font-size: 1.15rem; font-weight: 700; color: #0F6B66; margin-top: 1.125rem; margin-bottom: 0.5rem; }
    .cms-content h4 { font-size: 1rem; font-weight: 600; color: #0F172A; margin-top: 0.875rem; margin-bottom: 0.375rem; }
    .cms-content p { font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.7; color: #334155; }
    .cms-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
    .cms-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
    .cms-content li { font-size: 0.875rem; margin-bottom: 0.4rem; color: #334155; line-height: 1.6; }
    .cms-content a { color: #0F6B66; text-decoration: underline; font-weight: 600; }
    .cms-content a:hover { color: #0A4744; }
    .cms-content table { width: 100%; border-collapse: collapse; margin-bottom: 1.25rem; }
    .cms-content table th, .cms-content table td { border: 1px solid #CBD5E1; padding: 0.625rem 0.875rem; text-align: left; font-size: 0.875rem; }
    .cms-content table th { background-color: #F8FAFC; font-weight: 700; color: #0F172A; }
    .cms-content blockquote { border-left: 4px solid #0F6B66; padding-left: 1rem; font-style: italic; color: #475569; margin: 1.25rem 0; background-color: #F8FAFC; padding-top: 0.5rem; padding-bottom: 0.5rem; border-radius: 0 0.5rem 0.5rem 0; }
    .cms-content img { max-width: 100%; height: auto; border-radius: 0.75rem; margin: 1rem 0; }
    .cms-content hr { border-color: #E2E8F0; margin: 1.5rem 0; }
</style>
@endpush

@section('content')

<!-- Header Banner -->
<div class="bg-[var(--primary-dark)] text-white py-12 px-4">
    <div class="max-w-5xl mx-auto text-center sm:text-left">
        <span class="inline-block bg-sky-500/20 text-sky-200 border border-sky-400/30 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
            Company Information
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold">{{ $page->title }}</h1>
        <p class="text-sky-200 text-xs sm:text-sm mt-1">Petchemparts - Premier Petchemparts & Industrial Equipment Supplier</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-10">
        <div class="cms-content">
            {!! $page->content !!}
        </div>
    </div>
</div>

@endsection
