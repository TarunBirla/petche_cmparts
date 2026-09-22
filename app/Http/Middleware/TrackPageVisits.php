<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageVisit;
use App\Models\Product;
use App\Models\Manufacturer;
use App\Services\GeoIPService;

class TrackPageVisits
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests and ignore non-200 responses
        if (!$request->isMethod('GET') || $response->getStatusCode() !== 200) {
            return $response;
        }

        // Ignore admin panel requests, debugbar, and static assets
        $path = $request->path();
        if (
            str_starts_with($path, 'admin') ||
            str_starts_with($path, 'api') ||
            str_starts_with($path, '_debugbar') ||
            $request->ajax()
        ) {
            return $response;
        }

        try {
            $routeName = $request->route() ? $request->route()->getName() : null;
            $pageName = null;
            $manufacturerName = null;
            $productTitle = null;

            if ($routeName === 'home' || $path === '/') {
                $pageName = 'Home';
            } elseif ($routeName === 'products.index') {
                if ($request->filled('search')) {
                    $pageName = 'Search Results';
                } elseif ($request->filled('category')) {
                    $pageName = 'Categories';
                    if ($request->filled('manufacturer')) {
                        $m = Manufacturer::where('slug', $request->manufacturer)->orWhere('id', $request->manufacturer)->first();
                        $manufacturerName = $m ? $m->name : $request->manufacturer;
                    }
                } elseif ($request->filled('manufacturer')) {
                    $pageName = 'Manufacturers';
                    $m = Manufacturer::where('slug', $request->manufacturer)->orWhere('id', $request->manufacturer)->first();
                    $manufacturerName = $m ? $m->name : $request->manufacturer;
                } else {
                    $pageName = 'All Products';
                }
            } elseif ($routeName === 'products.show') {
                $pageName = 'Product View';
                $slug = $request->route('slug');
                if ($slug) {
                    $product = Product::where('slug', $slug)->with('manufacturer')->first();
                    if ($product) {
                        $manufacturerName = $product->manufacturer ? $product->manufacturer->name : null;
                        $partNum = $product->part_number ? $product->part_number : 'N/A';
                        $productTitle = $product->name . " ({$partNum})";
                    }
                }
            } elseif ($routeName === 'categories.index') {
                $pageName = 'Categories';
            } elseif ($routeName === 'manufacturers.index') {
                $pageName = 'Manufacturers';
            } elseif (in_array($routeName, ['about-us', 'delivery', 'delivery-and-returns', 'terms-and-conditions'])) {
                $pageName = 'About Us';
            } elseif ($routeName === 'contact') {
                $pageName = 'Contact Us';
            } elseif ($routeName === 'login') {
                $pageName = 'Login';
            } elseif ($routeName === 'register') {
                $pageName = 'Register';
            } elseif ($routeName === 'page.show') {
                $slug = $request->route('slug');
                $pageName = ($slug === 'about-us') ? 'About Us' : 'CMS Page';
            }

            if ($pageName) {
                $ip = $request->ip();
                [$browser, $platform] = $this->parseUserAgent($request->header('User-Agent'));

                $userName = auth()->check() ? auth()->user()->name : 'Guest';
                $userId = auth()->check() ? auth()->id() : null;

                PageVisit::create([
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'page_name' => $pageName,
                    'url' => $request->fullUrl(),
                    'manufacturer_name' => $manufacturerName,
                    'product_title' => $productTitle,
                    'quote_request_id' => null,
                    'ip' => $ip,
                    'browser' => $browser,
                    'platform' => $platform,
                ]);

                // Asynchronously or quickly resolve IP geo cache
                GeoIPService::resolveIp($ip);
            }
        } catch (\Exception $e) {
            // Silently ignore tracking exceptions so user browsing experience is never interrupted
        }

        return $response;
    }

    private function parseUserAgent(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return ['Other', 'Other'];
        }

        $browser = 'Other';
        if (preg_match('/Edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/OPR|Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/MSIE|Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        }

        $platform = 'Other';
        if (preg_match('/Windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $platform = 'Mac';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $platform = 'iOS';
        }

        return [$browser, $platform];
    }
}
