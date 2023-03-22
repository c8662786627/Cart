<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    
    protected $fillable = ['user_id', 'total'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->cartItems as $cartItem) {
            $total += $cartItem->total;
        }
        return $total;
    }
}
