<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'product_id',
        'amount',
        'valid_from',
        'valid_until'
    ];

    public function groups()
    {
        return $this->hasMany(DiscountGroup::class);
    }
}
