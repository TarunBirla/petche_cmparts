<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with(['manufacturer', 'category', 'subCategory', 'pdf']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('part_number', 'like', "%{$search}%")
                  ->orWhere('model_number', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('manufacturer')) {
            $query->whereHas('manufacturer', function ($q) use ($request) {
                $q->where('slug', $request->manufacturer)->orWhere('id', $request->manufacturer);
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category)->orWhere('id', $request->category);
            });
        }

        if ($request->filled('subcategory')) {
            $query->whereHas('subCategory', function ($q) use ($request) {
                $q->where('slug', $request->subcategory)->orWhere('id', $request->subcategory);
            });
        }

        $products = $query->latest()->paginate(6)->withQueryString();
        $categories = Category::where('is_active', true)->with('subCategories')->get();
        $manufacturers = Manufacturer::where('is_active', true)->get();

        $selectedCategory = $request->filled('category') ? Category::where('slug', $request->category)->orWhere('id', $request->category)->first() : null;
        $selectedManufacturer = $request->filled('manufacturer') ? Manufacturer::where('slug', $request->manufacturer)->orWhere('id', $request->manufacturer)->first() : null;
        $selectedSubcategory = $request->filled('subcategory') ? SubCategory::where('slug', $request->subcategory)->orWhere('id', $request->subcategory)->first() : null;

        return view('frontend.products.index', compact(
            'products',
            'categories',
            'manufacturers',
            'selectedCategory',
            'selectedManufacturer',
            'selectedSubcategory'
        ));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['manufacturer', 'category', 'subCategory', 'pdf'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->category_id;
        $subcategories = SubCategory::where('category_id', $categoryId)->where('is_active', true)->get(['id', 'name', 'slug']);
        return response()->json($subcategories);
    }
}
