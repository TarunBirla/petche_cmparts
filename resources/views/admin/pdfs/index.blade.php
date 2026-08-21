@extends('layouts.admin')

@section('title', 'Manage PDF Documents')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">PDF Technical Documents Library</h3>
        <p class="text-xs text-slate-500">Upload datasheets, catalogs, and technical manuals to attach optional download links to products.</p>
    </div>
    <a href="{{ route('admin.pdfs.create') }}" class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <span>Upload PDF Document</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-600 font-bold uppercase tracking-wider border-b">
            <tr>
                <th class="p-4">Document Title</th>
                <th class="p-4">Attached Products</th>
                <th class="p-4">File Link</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($pdfs as $pdf)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="p-4 font-bold text-slate-900 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-file-pdf text-rose-600 text-lg"></i>
                            <span>{{ $pdf->title }}</span>
                        </div>
                    </td>
                    <td class="p-4 font-semibold text-sky-800">{{ $pdf->products_count }} Product(s)</td>
                    <td class="p-4">
                        <a href="{{ asset($pdf->file_path) }}" target="_blank" class="text-sky-600 hover:underline font-mono text-[11px] flex items-center gap-1">
                            <i class="fa-solid fa-external-link text-[10px]"></i> View File
                        </a>
                    </td>
                    <td class="p-4 text-center">
                        <div class="inline-flex gap-2">
                            <a href="{{ route('admin.pdfs.edit', $pdf->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-semibold transition">Edit Title / File</a>
                            <form action="{{ route('admin.pdfs.destroy', $pdf->id) }}" method="POST" onsubmit="return confirm('Delete this PDF document?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-1.5 rounded-lg font-semibold transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-400">No PDF documents uploaded yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $pdfs->links() }}</div>
@endsection
