<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Image;
use App\Models\Price;
use App\DTO\ProductDTO;
use App\Models\Product;
use App\Models\Storage;
use App\Helpers\UploadFile;
use App\Models\ProductImage;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Models\ProductStorage;
use App\Contracts\ProductContract;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProductRequest;
use App\Helpers\ImagePivotTableRemover;
use App\Exceptions\BatchDeleteException;
use App\Http\Requests\ImageBatchRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\ProductSearchRequest;
use App\Http\Requests\ProductStorageRequest;
use App\Http\Requests\BatchProductStorageRequest;

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
     // $group_id = $request->validated()['group_id'] ?? null;
    // $product = Product::find($id);

    //  dd($product->prices->where('group_id', $group_id)->first());
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

  public function addPicturesToProduct(ImageRequest $request, int $id)
  {
    $product = Product::find($id);

    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    $user_id = auth()->user()->id;

    // Storage doesn't belong to auth user, but exist in DB
    if ($user_id !== $product->account->id) {
      throw new EntityNotFoundException('Product not found');
    }

    $images = $request->validated()['images'];

    foreach ($images as $image)
    {
      $src = UploadFile::move($image);
      $image_id = Image::create($src)->id;
      $storageImage = ProductImage::create([
        'product_id' => $id,
        'image_id'   => $image_id
      ]);
    }
  }

  public function deletePicturesFromProduct(ImageBatchRequest $request, int $id)
  {
    $imageIDS = $request->validated()['images'];

    ImagePivotTableRemover::remove('image_product', $imageIDS, $id);
  }

  public function addProductToStorage(ProductStorageRequest $request , int $id)
  {
    $storage = Storage::find($id);
    $account_id = auth()->user()->id;

    // Storage doesn't exist in DB
    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

      // Storage doesn't belong to auth user
    if ($storage->account_id !== $account_id) {
      throw new EntityNotFoundException('Storage not found');
    }

    $product = Product::find($request->product_id);

    // Product doesn't exist in DB
    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    // Product doesn't belong to auth user
    if ($product->account->id !== $account_id) {
      throw new EntityNotFoundException('Product not found');
    }

    $data = $request->validated();

    ProductStorage::create([
      'product_id' => $data['product_id'],
      'storage_id' => $id,
      'quantity'   => $data['quantity']
    ]);

  }

  public function deleteProductFromStorage(BatchProductStorageRequest $request , int $id)
  {
    $storage = Storage::find($id);

    // Storage doesn't exist in DB
    if (!$storage) {
      throw new EntityNotFoundException('Storage not found');
    }

    $account_id = auth()->user()->id;

      // Storage doesn't belong to auth user
    if ($storage->account_id !== $account_id) {
      throw new EntityNotFoundException('Storage not found');
    }

    $data = $request->validated()['products'];

    $products = ProductStorage::whereIn('product_id', $data)
                              ->where('storage_id', $id)
                              ->count();

    if ($products === count($data)) {
      ProductStorage::whereIn('product_id', $data)
                    ->delete();
    } else {
      throw new BatchDeleteException('One of ids is not valid');
    }
  }
  public function addNewPriceToProduct(ProductPriceRequest $request , int $id)
  {
    $product = Product::find($id);

    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    $account_id = auth()->user()->id;

    // Product doesn't belong to auth user
    if ($product->account->id !== $account_id) {
      throw new EntityNotFoundException('Product not found');
    }

    $data = $request->validated();
    $group_id = $data['group_id'] ?? null;
    $amount = $data['amount'];

    // group id has been passed
    if ($group_id) {
      $group = Group::find($group_id);

      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }

      if (($group->account_id === null) || ($group_id->account_id === $account_id)) {
        Price::create([
          'product_id' => $id,
          'amount'     => $amount,
          'group_id'   => $group_id
        ]);
      }
    } else { // price is for everyone not specific price for group
      Price::create([
        'product_id' => $id,
        'amount'     => $amount,
        'group_id'   => $group_id
      ]);
    }
  }
  public function updatePriceToProduct(ProductPriceRequest $request , int $id)
  {
    $product = Product::find($id);

    if (!$product) {
      throw new EntityNotFoundException('Product not found');
    }

    $account_id = auth()->user()->id;

    // Product doesn't belong to auth user
    if ($product->account->id !== $account_id) {
      throw new EntityNotFoundException('Product not found');
    }

    $data = $request->validated();
    $group_id = $data['group_id'] ?? null;
    $amount = $data['amount'];

    if ($group_id) {

      $group = Group::find($group_id);

      if (!$group) {
        throw new EntityNotFoundException('Group not found');
      }

      $productPrice = Price::where([
        ['product_id', $id],
        ['group_id', $group_id]
      ])
      ->latest()->first();
      $productPrice->update([
        'amount'     => $amount,
        'product_id' => $id,
        'group_id'   => $group_id
      ]);

    } else {
      // group_id not passed for all users

      $productPrice = Price::where([
        ['product_id', $id],
        ['group_id', null]
      ])
      ->latest()->first();
      $productPrice->update([
        'amount'     => $amount,
        'product_id' => $id
      ]);
    }
  }
}
