<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Product;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Contracts\ProductContract;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductSearchRequest;

class ProductEloquentService extends BaseService implements ProductContract
{
  public function getProducts(ProductSearchRequest $request) //: PagedResponse
  {

    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;

    $product = new Product;
    $account_id =  auth()->user()->id;

    $acc = $product->where('account_id', $account_id);


  }

  public function findProduct(int $id) : ProductDTO
  {

  }

  public function addProduct(ProductRequest $request)
  {

  }

  public function updateProduct(ProductRequest $request, int $id)
  {

  }

  public function removeProduct(int $id)
  {

  }

  public function addPictureToProduct(array $images, int $id)
  {

  }

  public function removePicturesFromProduct(array $images, int $id)
  {

  }

}
