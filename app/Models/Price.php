<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
      'product_id',
      'amount',
      'group_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
