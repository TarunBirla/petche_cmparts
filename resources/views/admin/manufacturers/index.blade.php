@extends('layouts.admin')

@section('title', 'Manage Manufacturers')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Manufacturers Directory</h3>
        <p class="text-xs text-slate-500">Add, edit, or delete equipment manufacturers & brand logos.</p>
    </div>
    <a href="{{ route('admin.manufacturers.create') }}" class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i>
        <span>Add Manufacturer</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Logo</th>
                <th class="p-4">Manufacturer Name</th>
                <th class="p-4">Slug</th>
                <th class="p-4">Status</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($manufacturers as $manuf)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4">
                        @if($manuf->logo && file_exists(public_path($manuf->logo)))
                            <img src="{{ asset($manuf->logo) }}" alt="{{ $manuf->name }}" class="w-10 h-10 object-contain rounded border border-slate-200 p-1 bg-white">
                        @else
                            <div class="w-10 h-10 bg-sky-100 text-sky-700 font-bold rounded flex items-center justify-center text-sm">
                                {{ substr($manuf->name, 0, 1) }}
                            </div>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-slate-900 text-sm">{{ $manuf->name }}</td>
                    <td class="p-4 font-mono text-slate-500">{{ $manuf->slug }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $manuf->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $manuf->is_active ? 'Active' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.manufacturers.edit', $manuf->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-semibold transition">Edit</a>
                            <form action="{{ route('admin.manufacturers.destroy', $manuf->id) }}" method="POST" onsubmit="return confirm('Delete this manufacturer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">No manufacturers created yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $manufacturers->links() }}</div>
@endsection
