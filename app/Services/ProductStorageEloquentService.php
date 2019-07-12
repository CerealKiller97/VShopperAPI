<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\{
    Product,
    Storage,
    ProductStorage

};
use App\Exceptions\{
    BatchDeleteException,
    EntityNotFoundException

};
use App\Contracts\ProductStorageContract;
use App\Http\Requests\{
    ProductStorageRequest,
    BatchProductStorageRequest

};

class ProductStorageEloquentService extends BaseService implements ProductStorageContract
{
    /**
     * @param ProductStorageRequest $request
     * @param int                   $id
     *
     * @throws EntityNotFoundException
     */
    public function addProductToStorage(ProductStorageRequest $request, int $id): void
    {
        // Storage check
        $acc = auth()->user()->storages;
        $storage = Storage::find($id);
        $this->policy->can($acc, $storage, 'Storage');

        // Product check
        $acc = auth()->user()->products;
        $product = Product::find($request->product_id);
        $this->policy->can($acc, $product, 'Product');

        $data = $request->validated();

        ProductStorage::create(['product_id' => $data['product_id'], 'storage_id' => $id, 'quantity' => $data['quantity']]);
    }

    /**
     * @param BatchProductStorageRequest $request
     * @param int                        $id
     *
     * @throws BatchDeleteException
     * @throws EntityNotFoundException
     */
    public function deleteProductFromStorage(BatchProductStorageRequest $request, int $id): void
    {
        $acc = auth()->user()->storages;
        $storage = Storage::find($id);

        //$eager = Storage::with(['products'])->where('id', $id)->first();

        $this->policy->can($acc, $storage, 'Storage');

        $data = $request->validated()['products'];

        $products = ProductStorage::whereIn('product_id', $data)->where('storage_id', $id)->count();

        if ($products === count($data)) {
            $storage->products()->detach($data);
        } else {
            throw new BatchDeleteException('One of ids is not valid');
        }
    }
}

