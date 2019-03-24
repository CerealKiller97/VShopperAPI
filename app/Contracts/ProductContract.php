<?php

namespace App\Contracts;

use App\DTO\ProductDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\DiscountRequest;
use App\Http\Requests\ImageBatchRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\BatchProductStorageRequest;

interface ProductContract
{
  public function getProducts(ProductSearchRequest $request) ; // : PagedResponse;
  public function findProduct(int $id) : ProductDTO;
  public function addProduct(ProductRequest $request);
  public function updateProduct(ProductRequest $request, int $id);
  public function removeProduct(int $id);
  public function addPicturesToProduct(ImageRequest $request, int $id); // product id
  public function deletePicturesFromProduct(ImageBatchRequest $request, int $id); // product id
  public function addProductToStorage(ProductStorageRequest $request , int $id);
  public function deleteProductFromStorage(BatchProductStorageRequest $request , int $id);
  public function addNewPriceToProduct(ProductPriceRequest $request , int $id); // product_id
  public function updatePriceToProduct(ProductPriceRequest $request , int $id);
  public function addDiscountToProduct(DiscountRequest $request, int $id);
  public function upateDiscountFromProduct(DiscountRequest $request, int $id);
}
