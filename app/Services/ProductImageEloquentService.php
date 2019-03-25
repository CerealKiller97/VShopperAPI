<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use App\Helpers\UploadFile;
use App\Models\ProductImage;
use App\Services\BaseService;
use App\Http\Requests\ImageRequest;
use App\Contracts\ProductImageContract;
use App\Helpers\ImagePivotTableRemover;
use App\Http\Requests\ImageBatchRequest;
use App\Exceptions\EntityNotFoundException;

class ProductImageEloquentService extends BaseService implements ProductImageContract
{
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

}
