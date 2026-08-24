@extends('layouts.admin')

@section('title', 'Contact Message Details')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-bold text-sky-600 hover:underline flex items-center gap-1">
        <i class="fa-solid fa-arrow-left"></i> Back to Messages List
    </a>
</div>

<div class="max-w-3xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
    <div class="border-b pb-4 flex justify-between items-start">
        <div>
            <span class="text-[10px] uppercase font-bold text-slate-400 block">Contact Form Submission</span>
            <h3 class="text-xl font-bold text-slate-900">{{ $contactMessage->subject }}</h3>
            <span class="text-xs text-slate-400">Received on {{ $contactMessage->created_at->format('F d, Y \a\t H:i') }}</span>
        </div>
        <form action="{{ route('admin.contact-messages.destroy', $contactMessage->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs px-3 py-1.5 rounded-lg font-semibold transition">Delete Message</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs">
        <div>
            <span class="font-bold text-slate-400 block uppercase text-[10px]">Sender Name</span>
            <span class="font-bold text-slate-900 text-sm">{{ $contactMessage->name }}</span>
        </div>
        <div>
            <span class="font-bold text-slate-400 block uppercase text-[10px]">Email Address</span>
            <a href="mailto:{{ $contactMessage->email }}" class="font-bold text-sky-600 hover:underline">{{ $contactMessage->email }}</a>
        </div>
        <div>
            <span class="font-bold text-slate-400 block uppercase text-[10px]">Phone Number</span>
            <span class="font-mono font-semibold text-slate-800">{{ $contactMessage->phone ?? 'N/A' }}</span>
        </div>
    </div>

    <div>
        <h4 class="font-bold text-xs uppercase text-slate-500 mb-2">Message Body</h4>
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 text-xs text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $contactMessage->message }}
        </div>
    </div>

    <div class="pt-4 border-t flex justify-end">
        <a href="mailto:{{ $contactMessage->email }}?subject=RE:%20{{ urlencode($contactMessage->subject) }}" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white text-xs font-bold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-reply"></i>
            <span>Reply via Email</span>
        </a>
    </div>
</div>
@endsection
