<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'discount',
        'is_active',
        'in_stock',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'discount'  => 'decimal:2',
        'is_active' => 'boolean',
        'in_stock'  => 'boolean',
    ];

    /**
     * A product can belong to many order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
