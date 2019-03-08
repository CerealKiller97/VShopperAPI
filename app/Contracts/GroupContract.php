<?php

namespace App\Contracts;

interface GroupContract
{
  public function getAllProducts();
  public function addProduct();
  public function removeProduct(int $id);
}
