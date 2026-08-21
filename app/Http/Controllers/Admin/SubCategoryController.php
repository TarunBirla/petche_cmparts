<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->latest()->paginate(15);
        return view('admin.subcategories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategories'), $imageName);
            $imagePath = 'uploads/subcategories/' . $imageName;
        }

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'Sub-category created successfully.');
    }

    public function edit(SubCategory $subcategory)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = $subcategory->image;
        if ($request->hasFile('image')) {
            if ($subcategory->image && file_exists(public_path($subcategory->image))) {
                @unlink(public_path($subcategory->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategories'), $imageName);
            $imagePath = 'uploads/subcategories/' . $imageName;
        }

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'Sub-category updated successfully.');
    }

    public function destroy(SubCategory $subcategory)
    {
        if ($subcategory->image && file_exists(public_path($subcategory->image))) {
            @unlink(public_path($subcategory->image));
        }
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')->with('success', 'Sub-category deleted successfully.');
    }
}
