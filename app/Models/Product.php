<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'shop_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function product_images()
    {
        return $this->hasMany(Product_image::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    public function cart_item()
    {
        return $this->hasMany(Cart_item::class);
    }

    public function order_detail()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function isFavorited()
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return false;
        }

        // Cek apakah produk sudah di-favorite oleh user yang login
        return $this->favorites()->where('buyer_id', Auth::id())->exists();
    }
}
