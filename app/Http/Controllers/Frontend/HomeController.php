<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->with(['subCategories' => function ($q) {
                $q->where('is_active', true);
            }])
            ->withCount('products')
            ->get();
            
        $manufacturers = Manufacturer::where('is_active', true)
            ->withCount('products')
            ->get();

        $topCategories = Category::where('is_active', true)
            ->with(['products' => function ($q) {
                $q->where('is_active', true)->with(['manufacturer', 'category', 'pdf'])->latest()->take(12);
            }])
            ->withCount('products')
            ->take(5)
            ->get();

        $allFeaturedProducts = Product::where('is_active', true)
            ->with(['manufacturer', 'category', 'pdf'])
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.home', compact('categories', 'manufacturers', 'topCategories', 'allFeaturedProducts'));
    }

    public function categories()
    {
        $categories = Category::where('is_active', true)
            ->with(['subCategories' => function ($q) {
                $q->where('is_active', true);
            }])
            ->withCount('products')
            ->paginate(6);

        return view('frontend.categories.index', compact('categories'));
    }

    public function manufacturers()
    {
        $manufacturers = Manufacturer::where('is_active', true)
            ->withCount('products')
            ->paginate(8);

        return view('frontend.manufacturers.index', compact('manufacturers'));
    }
}
