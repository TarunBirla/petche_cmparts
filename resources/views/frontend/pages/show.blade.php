@extends('layouts.app')

@section('title', $page->title . ' - Petchemparts')

@section('content')

<!-- Header Banner -->
<div class="bg-[#13A1F3] text-white py-12 px-4">
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
        <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
            {!! $page->content !!}
        </div>
    </div>
</div>

@endsection
