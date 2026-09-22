<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    use HasFactory;

    protected $table = 'page_visits';

    protected $fillable = [
        'user_id',
        'user_name',
        'page_name',
        'url',
        'manufacturer_name',
        'product_title',
        'quote_request_id',
        'ip',
        'browser',
        'platform'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function geoCache()
    {
        return $this->hasOne(IpGeoCache::class, 'ip', 'ip');
    }

    public function getLocationAttribute()
    {
        if (!$this->geoCache) {
            return '—';
        }

        $parts = array_filter([
            $this->geoCache->city,
            $this->geoCache->region,
            $this->geoCache->country
        ]);

        return !empty($parts) ? implode(', ', $parts) : '—';
    }
}
