<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addres extends Model
{
    protected $fillable = [
        'user_id',
        'negara',
        'kota',
        'alamat',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
