<?php

namespace Modules\PopularProducts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Products\Models\Product;

class PopularProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'popular_products';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}