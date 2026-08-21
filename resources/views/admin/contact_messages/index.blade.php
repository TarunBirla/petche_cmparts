@extends('layouts.admin')

@section('title', 'Manage Contact Inquiries')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Contact Us Inquiries</h3>
        <p class="text-xs text-slate-500">View and respond to direct contact messages submitted by website visitors.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Sender Name</th>
                <th class="p-4">Email / Phone</th>
                <th class="p-4">Subject</th>
                <th class="p-4">Received Date</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($messages as $msg)
                <tr class="hover:bg-slate-50/80 transition {{ !$msg->is_read ? 'bg-sky-50/50 font-bold' : '' }}">
                    <td class="p-4">
                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            @if(!$msg->is_read)
                                <span class="w-2 h-2 rounded-full bg-sky-600" title="Unread"></span>
                            @endif
                            <span>{{ $msg->name }}</span>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-slate-800">{{ $msg->email }}</div>
                        <div class="text-[11px] text-slate-400 font-mono">{{ $msg->phone ?? 'N/A' }}</div>
                    </td>
                    <td class="p-4 text-slate-700 font-medium">{{ $msg->subject }}</td>
                    <td class="p-4 text-slate-500 text-[11px]">{{ $msg->created_at->format('M d, Y - H:i') }}</td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.contact-messages.show', $msg->id) }}" class="bg-sky-600 hover:bg-sky-700 text-white px-3 py-1.5 rounded-lg font-bold transition">View Message</a>
                            <form action="{{ route('admin.contact-messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this contact message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">No contact messages received yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $messages->links() }}</div>
@endsection
