<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
  protected $table = 'image_product';

    protected $fillable = [
        'product_id',
        'image_id'
    ];

    public function product()
    {
      return $this->belongsToMany(Product::class);
    }

    public function image()
    {
      return $this->belongsToMany(Image::class);
    }
}
