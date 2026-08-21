<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer_id',
        'category_id',
        'sub_category_id',
        'pdf_id',
        'name',
        'slug',
        'part_number',
        'model_number',
        'summary',
        'description',
        'quantity',
        'price',
        'images',
        'is_active'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function pdf()
    {
        return $this->belongsTo(Pdf::class);
    }
}
