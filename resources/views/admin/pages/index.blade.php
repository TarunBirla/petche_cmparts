@extends('layouts.admin')

@section('title', 'Manage CMS Pages')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">CMS Pages Directory</h3>
        <p class="text-xs text-slate-500">Manage site content pages such as About Us, Delivery, Terms & Conditions.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i>
        <span>Add New Page</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Page Title</th>
                <th class="p-4">URL Slug</th>
                <th class="p-4">Status</th>
                <th class="p-4">Last Updated</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($pages as $page)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4 font-bold text-slate-900 text-sm">
                        <a href="{{ url($page->slug) }}" target="_blank" class="hover:text-sky-600 flex items-center gap-2">
                            <i class="fa-solid fa-file-lines text-sky-600"></i>
                            <span>{{ $page->title }}</span>
                        </a>
                    </td>
                    <td class="p-4 font-mono text-slate-500">/{{ $page->slug }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $page->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $page->is_active ? 'Active' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="p-4 text-slate-500 text-[11px]">{{ $page->updated_at->format('M d, Y') }}</td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-semibold transition">Edit Content</a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Delete this CMS page?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">No CMS pages created yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $pages->links() }}</div>
@endsection
