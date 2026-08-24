@extends('layouts.admin')

@section('title', 'Manage Sub-Categories')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Sub-Categories Directory</h3>
        <p class="text-xs text-slate-500">Organize parent categories into sub-categories.</p>
    </div>
    <a href="{{ route('admin.subcategories.create') }}" class="bg-[var(--primary-dark)] hover:bg-sky-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i>
        <span>Add Sub-Category</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Sub-Category Name</th>
                <th class="p-4">Parent Category</th>
                <th class="p-4">Image</th>
                <th class="p-4">Status</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($subCategories as $sub)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4 font-bold text-slate-900 text-sm">{{ $sub->name }}</td>
                    <td class="p-4">
                        <span class="bg-sky-50 text-sky-800 font-semibold px-2.5 py-1 rounded border border-sky-200">
                            {{ $sub->category->name ?? 'None' }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if($sub->image && file_exists(public_path($sub->image)))
                            <img src="{{ asset($sub->image) }}" alt="{{ $sub->name }}" class="w-10 h-8 object-cover rounded border">
                        @else
                            <span class="text-slate-400">None</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $sub->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $sub->is_active ? 'Active' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.subcategories.edit', $sub->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-semibold transition">Edit</a>
                            <form action="{{ route('admin.subcategories.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Delete this sub-category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">No sub-categories added yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $subCategories->links() }}</div>
@endsection
