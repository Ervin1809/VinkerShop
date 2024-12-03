<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    protected $fillable = [
        'shopName',
        'seller_id', // Tambahkan seller_id jika ingin mendukung mass assignment
        'shop_image',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
