<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        // OrderDetail milik satu Order
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        // OrderDetail milik satu Product
        return $this->belongsTo(Product::class);
    }
}
