<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id',);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id',);
    }
    public function shipping() {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    public function valueCoupon() {
        $discount = 0;
        $coupon = $this->coupon;
        if ($coupon) {
            if ($coupon->condition == 1) {
                $discount = $coupon->number;
            } else {
                $discount = $coupon->number * 0.01 * (int)str_replace(',', '', $this->total);
            }
        }
        return $discount;
    }
}
