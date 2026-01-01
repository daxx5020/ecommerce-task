<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductActivityLog extends Model
{
    protected $fillable = [
        'product_id',
        'action',
        'old_data',
        'new_data',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];
}
