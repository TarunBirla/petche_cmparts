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

        $firstProduct = null;
        $productTitles = [];
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
                if (!$firstProduct) {
                    $firstProduct = $product;
                }
                $productTitles[] = $product->name . ($product->part_number ? " ({$product->part_number})" : "");
            }
        }

        // Record Quote Submission page visit event for analytics
        try {
            $userAgent = $request->header('User-Agent');
            $browser = 'Other';
            if (preg_match('/Edg/i', $userAgent)) $browser = 'Edge';
            elseif (preg_match('/Chrome/i', $userAgent)) $browser = 'Chrome';
            elseif (preg_match('/Safari/i', $userAgent)) $browser = 'Safari';
            elseif (preg_match('/Firefox/i', $userAgent)) $browser = 'Firefox';

            $platform = 'Other';
            if (preg_match('/Windows/i', $userAgent)) $platform = 'Windows';
            elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) $platform = 'Mac';
            elseif (preg_match('/Linux/i', $userAgent)) $platform = 'Linux';
            elseif (preg_match('/Android/i', $userAgent)) $platform = 'Android';
            elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) $platform = 'iOS';

            \App\Models\PageVisit::create([
                'user_id' => auth()->id(),
                'user_name' => $request->customer_name ?: (auth()->check() ? auth()->user()->name : 'Guest'),
                'page_name' => 'Quote Submission',
                'url' => $request->fullUrl(),
                'manufacturer_name' => $firstProduct && $firstProduct->manufacturer ? $firstProduct->manufacturer->name : null,
                'product_title' => !empty($productTitles) ? implode(', ', array_slice($productTitles, 0, 2)) : null,
                'quote_request_id' => $requestNumber,
                'ip' => $request->ip(),
                'browser' => $browser,
                'platform' => $platform,
            ]);
            \App\Services\GeoIPService::resolveIp($request->ip());
        } catch (\Exception $e) {
            Log::error('Failed recording PageVisit for quote submission: ' . $e->getMessage());
        }

        // Send Email Notification to Admin (sales@sparelyx.com)
        try {
            $adminEmail = 'sales@sparelyx.com';
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
