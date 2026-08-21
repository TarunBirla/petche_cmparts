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

        // Send Email Notification to Admin
        try {
            $adminEmail = config('mail.from.address', 'phil.andreson@nexteck.uk');
            Mail::to($adminEmail)->send(new ProductRequestSubmitted($productRequest));
        } catch (\Exception $e) {
            Log::error('Failed to send Product Request email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Your product request has been submitted successfully! Our sales team will get back to you shortly.',
            'request_number' => $requestNumber,
        ]);
    }
}
