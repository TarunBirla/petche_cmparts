<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(ProductRequestItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
