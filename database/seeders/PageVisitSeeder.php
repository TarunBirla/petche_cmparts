<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageVisit;
use App\Models\IpGeoCache;
use App\Models\User;
use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Support\Carbon;

class PageVisitSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pre-populate some IP Geo Cache entries
        $geoSamples = [
            ['ip' => '86.12.34.56', 'country' => 'United Kingdom', 'region' => 'England', 'city' => 'London'],
            ['ip' => '104.28.19.112', 'country' => 'United States', 'region' => 'California', 'city' => 'San Jose'],
            ['ip' => '185.220.101.5', 'country' => 'Germany', 'region' => 'Bavaria', 'city' => 'Munich'],
            ['ip' => '5.30.12.89', 'country' => 'United Arab Emirates', 'region' => 'Dubai', 'city' => 'Dubai'],
            ['ip' => '103.21.126.4', 'country' => 'India', 'region' => 'Maharashtra', 'city' => 'Mumbai'],
            ['ip' => '142.250.190.46', 'country' => 'Canada', 'region' => 'Ontario', 'city' => 'Toronto'],
            ['ip' => '127.0.0.1', 'country' => null, 'region' => null, 'city' => null],
        ];

        foreach ($geoSamples as $geo) {
            IpGeoCache::updateOrCreate(
                ['ip' => $geo['ip']],
                [
                    'country' => $geo['country'],
                    'region' => $geo['region'],
                    'city' => $geo['city'],
                    'resolved_at' => now()
                ]
            );
        }

        // 2. Sample Industrial Parts & Manufacturers
        $spareParts = [
            ['title' => 'Pressure Transmitter (RM-3051-CD)', 'manufacturer' => 'Rosemount'],
            ['title' => 'Digital Multimeter 87V (FLUKE-87V)', 'manufacturer' => 'Fluke'],
            ['title' => 'Flow Controller (YOKO-FC-900)', 'manufacturer' => 'Yokogawa'],
            ['title' => 'PLC Expansion Module (S7-1200)', 'manufacturer' => 'Siemens'],
            ['title' => 'Motor Protection Relay (TESYS-E)', 'manufacturer' => 'Schneider Electric'],
            ['title' => 'Pneumatic Actuator (ABB-PA-50)', 'manufacturer' => 'ABB'],
            ['title' => 'Control Valve Assembly (CV-3000-SS)', 'manufacturer' => 'Emerson'],
        ];

        $pages = [
            'Home', 'All Products', 'Product View', 'Categories',
            'Manufacturers', 'About Us', 'Contact Us', 'Search Results',
            'Request Quote', 'Login', 'Register', 'Quote Submission'
        ];

        $browsers = ['Chrome', 'Chrome', 'Chrome', 'Safari', 'Firefox', 'Edge'];
        $platforms = ['Windows', 'Windows', 'Mac', 'Linux', 'Android', 'iOS'];
        $users = ['Guest', 'Guest', 'John Sales', 'Alex Petrochem', 'Fatima Al-Sayed', 'David Miller'];
        $ips = ['86.12.34.56', '104.28.19.112', '185.220.101.5', '5.30.12.89', '103.21.126.4', '142.250.190.46', '127.0.0.1'];

        // Seed 120 page visits spread across past 30 days
        for ($i = 0; $i < 120; $i++) {
            $daysAgo = rand(0, 29);
            $hoursAgo = rand(0, 23);
            $minutesAgo = rand(0, 59);
            $visitedAt = Carbon::now()->subDays($daysAgo)->subHours($hoursAgo)->subMinutes($minutesAgo);

            $page = $pages[array_rand($pages)];
            $part = $spareParts[array_rand($spareParts)];
            $user = $users[array_rand($users)];
            $ip = $ips[array_rand($ips)];

            $mName = null;
            $pTitle = null;
            $quoteReqId = null;

            if ($page === 'Product View') {
                $mName = $part['manufacturer'];
                $pTitle = $part['title'];
            } elseif ($page === 'Manufacturers') {
                $mName = $part['manufacturer'];
            } elseif ($page === 'Request Quote') {
                $pTitle = $part['title'];
            } elseif ($page === 'Quote Submission') {
                $mName = $part['manufacturer'];
                $pTitle = $part['title'];
                $quoteReqId = 'REQ-2026-' . strtoupper(substr(md5(rand()), 0, 6));
            }

            PageVisit::create([
                'user_id' => $user !== 'Guest' ? 1 : null,
                'user_name' => $user,
                'page_name' => $page,
                'url' => 'https://sparelyx.com/' . strtolower(str_replace(' ', '-', $page)),
                'manufacturer_name' => $mName,
                'product_title' => $pTitle,
                'quote_request_id' => $quoteReqId,
                'ip' => $ip,
                'browser' => $browsers[array_rand($browsers)],
                'platform' => $platforms[array_rand($platforms)],
                'created_at' => $visitedAt,
                'updated_at' => $visitedAt,
            ]);
        }
    }
}
