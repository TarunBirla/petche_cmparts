<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpGeoCache extends Model
{
    use HasFactory;

    protected $table = 'ip_geo_caches';

    protected $fillable = [
        'ip',
        'country',
        'region',
        'city',
        'resolved_at'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];
}
