<?php

namespace App\Models;

class Cart extends BaseModel
{
    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotal($column = 'price')
    {
        return $this->items()->sum($column);
    }

    public function getAmountDue()
    {
        return min($this->getTotal(), $this->getTotal('discount_price'));
    }
}
