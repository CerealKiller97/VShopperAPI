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
    'product_type_id',
    'name',
    'description'
  ];

  public function account()
  {
    return $this->belongsTo(Account::class);
  }

  public function prices()
  {
    return $this->hasMany(Price::class);
  }

  public function discounts()
  {
    return $this->hasMany(Discount::class);
  }

  public function storages()
  {
    return $this->belongsToMany(Storage::class);
  }

  public function brand()
  {
    return $this->belongsTo(Brand::class);
  }

  public function unit()
  {
    return $this->belongsTo(Unit::class);
  }

  public function vendor()
  {
    return $this->belongsTo(Vendor::class);
  }

  public function images()
  {
    return $this->belongsToMany(Image::class);
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }

  public function scopePriceByGroup($query, $id)
  {
    return $query->prices->where('group_id', $id);
  }
}
