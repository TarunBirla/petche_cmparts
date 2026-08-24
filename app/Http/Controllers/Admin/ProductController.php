<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Pdf;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['manufacturer', 'category', 'subCategory', 'pdf']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('part_number', 'like', "%{$search}%")
                  ->orWhere('model_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('manufacturer_id')) {
            $query->where('manufacturer_id', $request->manufacturer_id);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();
        $manufacturers = Manufacturer::all();

        return view('admin.products.index', compact('products', 'categories', 'manufacturers'));
    }

    public function create()
    {
        $manufacturers = Manufacturer::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        $pdfs = Pdf::all();

        return view('admin.products.create', compact('manufacturers', 'categories', 'pdfs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'pdf_id' => 'nullable|exists:pdfs,id',
            'name' => 'required|string|max:255|unique:products,name',
            'part_number' => 'required|string|max:255',
            'model_number' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $imageName = time() . '_' . $key . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $imageName);
                $imagePaths[] = 'uploads/products/' . $imageName;
            }
        }

        Product::create([
            'manufacturer_id' => $request->manufacturer_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'pdf_id' => $request->pdf_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'part_number' => $request->part_number,
            'model_number' => $request->model_number,
            'summary' => $request->summary,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'images' => count($imagePaths) > 0 ? $imagePaths : null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $manufacturers = Manufacturer::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->get();
        $pdfs = Pdf::all();

        return view('admin.products.edit', compact('product', 'manufacturers', 'categories', 'subcategories', 'pdfs'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'pdf_id' => 'nullable|exists:pdfs,id',
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'part_number' => 'required|string|max:255',
            'model_number' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        $imagePaths = $product->images ?? [];

        // 1. If replace_existing is checked, unlink all current images
        if ($request->has('replace_existing') && $request->replace_existing == '1') {
            foreach ($imagePaths as $img) {
                if (file_exists(public_path($img))) {
                    @unlink(public_path($img));
                }
            }
            $imagePaths = [];
        } 
        // 2. Remove specific images selected for removal
        elseif ($request->has('remove_images') && is_array($request->remove_images)) {
            $filteredPaths = [];
            foreach ($imagePaths as $index => $img) {
                if (in_array((string)$index, $request->remove_images) || in_array($img, $request->remove_images)) {
                    if (file_exists(public_path($img))) {
                        @unlink(public_path($img));
                    }
                } else {
                    $filteredPaths[] = $img;
                }
            }
            $imagePaths = array_values($filteredPaths);
        }

        // 3. Handle newly uploaded images
        if ($request->hasFile('images')) {
            $newImagePaths = [];
            foreach ($request->file('images') as $key => $file) {
                $imageName = time() . '_' . $key . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $imageName);
                $newImagePaths[] = 'uploads/products/' . $imageName;
            }

            // If set_primary is checked or if no existing images remain, place new images at the beginning
            if (($request->has('set_primary') && $request->set_primary == '1') || empty($imagePaths)) {
                $imagePaths = array_merge($newImagePaths, $imagePaths);
            } else {
                $imagePaths = array_merge($imagePaths, $newImagePaths);
            }
        }

        $product->update([
            'manufacturer_id' => $request->manufacturer_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'pdf_id' => $request->pdf_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'part_number' => $request->part_number,
            'model_number' => $request->model_number,
            'summary' => $request->summary,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'images' => count($imagePaths) > 0 ? array_values($imagePaths) : null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function deleteImage(Request $request, Product $product)
    {
        $imageIndex = $request->input('image_index');
        $imagePath = $request->input('image_path');

        $images = $product->images ?? [];
        $updatedImages = [];
        $deleted = false;

        foreach ($images as $index => $img) {
            if (($imageIndex !== null && (int)$imageIndex === $index) || ($imagePath && $imagePath === $img)) {
                if (file_exists(public_path($img))) {
                    @unlink(public_path($img));
                }
                $deleted = true;
            } else {
                $updatedImages[] = $img;
            }
        }

        if ($deleted) {
            $product->update(['images' => count($updatedImages) > 0 ? array_values($updatedImages) : null]);
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
    }

    public function destroy(Product $product)
    {
        if (!empty($product->images)) {
            foreach ($product->images as $img) {
                if (file_exists(public_path($img))) {
                    @unlink(public_path($img));
                }
            }
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->where('is_active', true)->get();
        return response()->json($subcategories);
    }
}
