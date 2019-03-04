<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStorage extends Model
{
    protected $fillable = [
        'product_id',
        'storage_id'
    ];
}
