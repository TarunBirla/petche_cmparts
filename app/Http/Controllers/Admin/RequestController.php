<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductRequest::withCount('items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()->paginate(15);
        return view('admin.requests.index', compact('requests'));
    }

    public function show(ProductRequest $productRequest)
    {
        $productRequest->load('items.product');
        return view('admin.requests.show', compact('productRequest'));
    }

    public function updateStatus(Request $request, ProductRequest $productRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,completed,cancelled',
        ]);

        $productRequest->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Request status updated successfully.');
    }

    public function destroy(ProductRequest $productRequest)
    {
        $productRequest->delete();
        return redirect()->route('admin.requests.index')->with('success', 'Request deleted successfully.');
    }
}
