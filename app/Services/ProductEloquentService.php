<?php

namespace App\Services;

use App\Models\Product;
use App\Contracts\ProductContract;

class ProductEloquentService implements ProductContract
{
  public function getAllProducts()
  {
    return Product::all();
  }

  public function addProduct()
  {
    # code...
  }

  public function removeProduct(int $id)
  {
    # code...
  }
}
