<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::latest()->paginate(15);
        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:manufacturers,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/manufacturers'), $imageName);
            $logoPath = 'uploads/manufacturers/' . $imageName;
        }

        Manufacturer::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'logo' => $logoPath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer created successfully.');
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:manufacturers,name,' . $manufacturer->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $logoPath = $manufacturer->logo;
        if ($request->hasFile('logo')) {
            if ($manufacturer->logo && file_exists(public_path($manufacturer->logo))) {
                @unlink(public_path($manufacturer->logo));
            }
            $image = $request->file('logo');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/manufacturers'), $imageName);
            $logoPath = 'uploads/manufacturers/' . $imageName;
        }

        $manufacturer->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'logo' => $logoPath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer updated successfully.');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        if ($manufacturer->logo && file_exists(public_path($manufacturer->logo))) {
            @unlink(public_path($manufacturer->logo));
        }
        $manufacturer->delete();

        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer deleted successfully.');
    }
}
