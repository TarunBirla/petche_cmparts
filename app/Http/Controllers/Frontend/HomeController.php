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
            
        $manufacturers = Manufacturer::where('is_active', true)->withCount('products')->get();
        $featuredProducts = Product::where('is_active', true)
            ->with(['manufacturer', 'category', 'pdf'])
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.home', compact('categories', 'manufacturers', 'featuredProducts'));
    }

    public function categories()
    {
        $categories = Category::where('is_active', true)
            ->with(['subCategories' => function ($q) {
                $q->where('is_active', true);
            }])
            ->withCount('products')
            ->get();

        return view('frontend.categories.index', compact('categories'));
    }

    public function manufacturers()
    {
        $manufacturers = Manufacturer::where('is_active', true)
            ->withCount('products')
            ->get();

        return view('frontend.manufacturers.index', compact('manufacturers'));
    }
}
