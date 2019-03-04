<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'account_id',
        'unit_id',
        'brand_id',
        'vendor_id',
        'name',
        'description'
    ];
}
