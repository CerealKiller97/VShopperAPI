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

    public function account()
    {
      return $this->belongsTo(Account::class);
    }

    public function prices()
    {
      return $this->hasMany(Price::class)->latest();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
