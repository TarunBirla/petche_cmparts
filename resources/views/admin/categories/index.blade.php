@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Categories Directory</h3>
        <p class="text-xs text-slate-500">Manage main equipment categories and image cards.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i>
        <span>Add Category</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Image Card</th>
                <th class="p-4">Category Name</th>
                <th class="p-4">Sub-Categories</th>
                <th class="p-4">Products</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $cat)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4">
                        @if($cat->image && file_exists(public_path($cat->image)))
                            <img src="{{ asset($cat->image) }}" alt="{{ $cat->name }}" class="w-12 h-10 object-cover rounded border border-slate-200">
                        @else
                            <div class="w-12 h-10 bg-slate-100 text-slate-400 font-bold rounded flex items-center justify-center text-xs">
                                No Img
                            </div>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-slate-900 text-sm">{{ $cat->name }}</td>
                    <td class="p-4 font-semibold text-sky-700">{{ $cat->sub_categories_count }} Sub-categories</td>
                    <td class="p-4 font-semibold text-slate-700">{{ $cat->products_count }} Products</td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-semibold transition">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">No categories added yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $categories->links() }}</div>
@endsection
