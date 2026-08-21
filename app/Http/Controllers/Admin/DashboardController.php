<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\Category;
use App\Models\Manufacturer;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalRequests = ProductRequest::count();
        $pendingRequests = ProductRequest::where('status', 'pending')->count();
        $totalCategories = Category::count();
        $totalManufacturers = Manufacturer::count();
        
        $recentRequests = ProductRequest::latest()->take(5)->get();
        $latestProducts = Product::with(['manufacturer', 'category'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalRequests',
            'pendingRequests',
            'totalCategories',
            'totalManufacturers',
            'recentRequests',
            'latestProducts'
        ));
    }
}
