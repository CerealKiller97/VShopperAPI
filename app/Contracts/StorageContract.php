<?php

namespace App\Contracts;

interface StorageContact
{
  public function getAllProducts();
  public function addProduct();
  public function removeProduct(int $id);
}
