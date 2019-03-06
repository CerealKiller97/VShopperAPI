<?php

namespace App\Contracts;

interface ProductContract
{
  public function getAllProducts();
  public function addProduct();
  public function removeProduct(int $id);
}
