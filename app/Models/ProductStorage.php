<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStorage extends Model
{
  protected $table = 'product_storage';

  protected $fillable = [
      'product_id',
      'storage_id',
      'quantity'
  ];

  public function product()
  {
    return $this->belongsToMany(Product::class);
  }

  public function storage()
  {
    return $this->belongsToMany(Storage::class);
  }
}
