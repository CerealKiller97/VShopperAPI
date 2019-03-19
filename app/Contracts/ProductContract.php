<?php

namespace App\Contracts;

use App\DTO\ProductDTO;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductSearchRequest;

interface ProductContract
{
  public function getProducts(ProductSearchRequest $request) ; // : PagedResponse;
  public function findProduct(int $id) : ProductDTO;
  public function addProduct(ProductRequest $request);
  public function updateProduct(ProductRequest $request, int $id);
  public function removeProduct(int $id);
  public function addPictureToProduct(array $images, int $id); // product id
  public function removePicturesFromProduct(array $images, int $id); // product id
}
