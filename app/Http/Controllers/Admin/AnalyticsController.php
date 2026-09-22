<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Manufacturer;
use App\Models\User;
use App\Models\PageVisit;
use App\Models\IpGeoCache;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // 1. Top Summary Cards Metrics
        $totalVisits = PageVisit::count();
        $todaysVisits = PageVisit::whereDate('created_at', Carbon::today())->count();
        $registeredUsers = User::count();
        $totalManufacturers = Manufacturer::count();
        $totalProducts = Product::count();
        $countriesCount = IpGeoCache::whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct('country')
            ->count('country');

        // 2. Last 30 Days Visit Analytics (Line Chart)
        $dates = [];
        $visitsMap = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::today()->subDays($i)->format('M d');
            $visitsMap[$d] = 0;
        }

        $rawVisits = PageVisit::select(DB::raw('DATE(created_at) as visit_date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::today()->subDays(29)->startOfDay())
            ->groupBy('visit_date')
            ->get();

        foreach ($rawVisits as $rv) {
            if (isset($visitsMap[$rv->visit_date])) {
                $visitsMap[$rv->visit_date] = (int) $rv->count;
            }
        }
        $chartDates = $dates;
        $chartVisits = array_values($visitsMap);

        // 3. Browser Usage (Pie Chart)
        $browserData = PageVisit::select('browser', DB::raw('COUNT(*) as total'))
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        // 4. Platform Usage (Pie/Bar Chart)
        $platformData = PageVisit::select('platform', DB::raw('COUNT(*) as total'))
            ->groupBy('platform')
            ->orderByDesc('total')
            ->get();

        // 5. Top Visited Pages
        $topPages = PageVisit::select('page_name', DB::raw('COUNT(*) as total'))
            ->groupBy('page_name')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        // 6. Page Visit History Table (Paginated, Searchable, Sortable by Date)
        $visitQuery = PageVisit::with('geoCache');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $visitQuery->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('page_name', 'like', "%{$search}%")
                  ->orWhere('manufacturer_name', 'like', "%{$search}%")
                  ->orWhere('product_title', 'like', "%{$search}%")
                  ->orWhere('quote_request_id', 'like', "%{$search}%")
                  ->orWhere('ip', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('platform', 'like', "%{$search}%");
            });
        }

        if ($request->filled('page_filter')) {
            $visitQuery->where('page_name', $request->page_filter);
        }

        $pageVisits = $visitQuery->latest()->paginate(10)->withQueryString();

        return view('admin.analytics.index', compact(
            'totalVisits',
            'todaysVisits',
            'registeredUsers',
            'totalManufacturers',
            'totalProducts',
            'countriesCount',
            'chartDates',
            'chartVisits',
            'browserData',
            'platformData',
            'topPages',
            'pageVisits'
        ));
    }
}
