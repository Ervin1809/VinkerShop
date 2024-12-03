<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_number',
        'buyer_id',
        'shop_id',  // Tambahkan shop_id
        'status',
        'payment_method',
        'shipping_cost',
        'total_amount',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')
                    ->withPivot('quantityOrdered');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
