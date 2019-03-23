<?php

namespace App\Contracts;

use App\DTO\ProductDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ImageBatchRequest;
use App\Http\Requests\ProductSearchRequest;

interface ProductContract
{
  public function getProducts(ProductSearchRequest $request) ; // : PagedResponse;
  public function findProduct(int $id) : ProductDTO;
  public function addProduct(ProductRequest $request);
  public function updateProduct(ProductRequest $request, int $id);
  public function removeProduct(int $id);
  public function addPicturesToProduct(ImageRequest $request, int $id); // product id
  public function deletePicturesFromProduct(ImageBatchRequest $request, int $id); // product id
}
