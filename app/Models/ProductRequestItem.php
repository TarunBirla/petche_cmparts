<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_request_id',
        'product_id',
        'product_name',
        'part_number',
        'price',
        'quantity'
    ];

    public function productRequest()
    {
        return $this->belongsTo(ProductRequest::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
