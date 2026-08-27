<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ProductRequestSubmitted;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please sign in or register an account before submitting a quote request.'
            ], 401);
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $requestNumber = 'REQ-' . date('Y') . '-' . strtoupper(Str::random(6));

        $productRequest = ProductRequest::create([
            'request_number' => $requestNumber,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            if ($product) {
                ProductRequestItem::create([
                    'product_request_id' => $productRequest->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'part_number' => $product->part_number,
                    'price' => $product->price,
                    'quantity' => $itemData['quantity'],
                ]);
            }
        }

        // Send Email Notification to Admin (sales@petchemparts.com)
        try {
            $adminEmail = 'sales@petchemparts.com';
            Mail::to($adminEmail)->send(new ProductRequestSubmitted($productRequest));
        } catch (\Exception $e) {
            Log::error('Failed sending Product Request admin email: ' . $e->getMessage());
        }

        // Send Email Confirmation to Customer
        try {
            Mail::to($productRequest->customer_email)->send(new \App\Mail\ProductRequestCustomerConfirmation($productRequest));
        } catch (\Exception $e) {
            Log::error('Failed sending Product Request customer email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Your product request has been submitted successfully! Our sales team will get back to you shortly.',
            'request_number' => $requestNumber,
        ]);
    }
}
