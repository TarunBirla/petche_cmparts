<?php

namespace App\Services;

use App\Models\IpGeoCache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoIPService
{
    /**
     * Resolve IP address to geographical location.
     * Caches result in `ip_geo_caches` table to prevent exceeding ip-api.com rate limits (45 req/min).
     *
     * @param string $ip
     * @return IpGeoCache|null
     */
    public static function resolveIp($ip)
    {
        if (empty($ip)) {
            return null;
        }

        // Return immediately for localhost or private IPs
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.') || str_starts_with($ip, '172.16.') || str_starts_with($ip, '172.31.')) {
            return IpGeoCache::firstOrCreate(
                ['ip' => $ip],
                ['country' => null, 'region' => null, 'city' => null, 'resolved_at' => now()]
            );
        }

        // Check if already in cache database
        $cached = IpGeoCache::where('ip', $ip)->first();
        if ($cached) {
            return $cached;
        }

        // Server-side HTTP call to ip-api.com (free tier, HTTP only, 45 req/min limit)
        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,message,country,regionName,city,query'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['status']) && $data['status'] === 'success') {
                    return IpGeoCache::create([
                        'ip' => $ip,
                        'country' => $data['country'] ?? null,
                        'region' => $data['regionName'] ?? null,
                        'city' => $data['city'] ?? null,
                        'resolved_at' => now(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::warning("GeoIP lookup failed for IP {$ip}: " . $e->getMessage());
        }

        // Save failed lookup in cache to prevent repeated failing external calls
        return IpGeoCache::create([
            'ip' => $ip,
            'country' => null,
            'region' => null,
            'city' => null,
            'resolved_at' => now(),
        ]);
    }
}
