<?php

namespace App\DTO;

class PriceDTO
{
  public $id;
  public $product_id;
  public $product; // relation to products
  public $amount;
}
