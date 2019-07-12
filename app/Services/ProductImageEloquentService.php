<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\{
    Image,
    Product,
    ProductImage

};
use App\Helpers\{
    UploadFile,
    ImagePivotTableRemover

};
use App\Http\Requests\{
    ImageRequest,
    ImageBatchRequest

};
use App\Contracts\ProductImageContract;
use App\Exceptions\{
    EntityNotFoundException,
    BatchDeleteException

};

class ProductImageEloquentService extends BaseService implements ProductImageContract
{
    /**
     * @param ImageRequest $request
     * @param int          $id
     *
     * @throws EntityNotFoundException
     */
    public function addPicturesToProduct(ImageRequest $request, int $id): void
    {
        $acc = auth()->user()->products;
        $product = Product::find($id);

        $this->policy->can($acc, $product, 'Product');

        $images = $request->validated()['images'];
        foreach ($images as $image) {
            $src = UploadFile::move($image);
            $image_id = Image::create($src)->id;
            $storageImage = ProductImage::create(['product_id' => $id, 'image_id' => $image_id]);
        }
    }

    /**
     * @param ImageBatchRequest $request
     * @param int               $id
     *
     * @throws EntityNotFoundException
     * @throws BatchDeleteException
     */
    public function deletePicturesFromProduct(ImageBatchRequest $request, int $id): void
    {
        $acc = auth()->user()->products;
        $product = Product::find($id);

        $this->policy->can($acc, $product, 'Product');

        $imageIDS = $request->validated()['images'];

        ImagePivotTableRemover::remove('image_product', $imageIDS, $id);
    }
}
