<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function category() {
        return $this->belongsTo(CategoryProduct::class,'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(BrandProduct::class, 'brand_id');
    }
    public function orderDetail() {
        return $this->hasOne(OrderDetail::class, 'product_id');
    }
}
