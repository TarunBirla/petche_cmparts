<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function index()
    {
        $pdfs = Pdf::withCount('products')->latest()->paginate(15);
        return view('admin.pdfs.index', compact('pdfs'));
    }

    public function create()
    {
        return view('admin.pdfs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:10240', // 10MB limit
        ]);

        $file = $request->file('pdf_file');
        $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->title)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/pdfs'), $fileName);
        $filePath = 'uploads/pdfs/' . $fileName;

        Pdf::create([
            'title' => $request->title,
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.pdfs.index')->with('success', 'PDF Document uploaded successfully.');
    }

    public function edit(Pdf $pdf)
    {
        return view('admin.pdfs.edit', compact('pdf'));
    }

    public function update(Request $request, Pdf $pdf)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
        ]);

        $filePath = $pdf->file_path;
        if ($request->hasFile('pdf_file')) {
            if ($pdf->file_path && file_exists(public_path($pdf->file_path))) {
                @unlink(public_path($pdf->file_path));
            }
            $file = $request->file('pdf_file');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->title)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pdfs'), $fileName);
            $filePath = 'uploads/pdfs/' . $fileName;
        }

        $pdf->update([
            'title' => $request->title,
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.pdfs.index')->with('success', 'PDF Document updated successfully.');
    }

    public function destroy(Pdf $pdf)
    {
        if ($pdf->file_path && file_exists(public_path($pdf->file_path))) {
            @unlink(public_path($pdf->file_path));
        }
        $pdf->delete();

        return redirect()->route('admin.pdfs.index')->with('success', 'PDF Document deleted successfully.');
    }
}
