<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\ProductTypeDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\ProductType;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    PagedRequest,
    ProductTypeRequest

};
use App\Contracts\ProductTypeContract;

class ProductTypeEloquentService extends BaseService implements ProductTypeContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getProductTypes(PagedRequest $request): PagedResponse
    {
        $page = $request->getPaging()->page;
        $perPage = $request->getPaging()->perPage;
        $name = $request->getPaging()->name;

        $productTypes = new ProductType;
        $account_id = auth()->user()->id;

        $acc = $productTypes->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $perPage, $page, $name);
        $productTypesCount = auth()->user()->productTypes->count();

        $default = ProductType::default()->get();

        $final = $default->merge($items);

        $unitsCount = $final->count();

        $productTypesArr = [];

        foreach ($final as $productType) {
            $productTypeDTO = new ProductTypeDTO;

            $productTypeDTO->id = $productType->id;
            $productTypeDTO->name = $productType->name;

            $productTypesArr[] = $productTypeDTO;
        }

        return new PagedResponse($productTypesArr, $unitsCount, $page);
    }

    /**
     * @param int $id
     *
     * @return ProductTypeDTO
     * @throws EntityNotFoundException
     */
    public function findProductType(int $id): ProductTypeDTO
    {
        $acc = auth()->user()->productTypes;
        $productType = ProductType::find($id);

        $this->policy->can($acc, $productType, 'Product type');

        $productTypeDTO = new ProductTypeDTO;

        $productTypeDTO->id = $productType->id;
        $productTypeDTO->name = $productType->name;
        $productTypeDTO->abbr = $productType->abbr;

        return $productTypeDTO;
    }

    /**
     * @param ProductTypeRequest $request
     */
    public function addProductType(ProductTypeRequest $request): void
    {
        $productType = ProductType::create($request->validated());
        auth()->user()->productTypes()->save($productType);
    }

    /**
     * @param ProductTypeRequest $request
     * @param int                $id
     *
     * @throws EntityNotFoundException
     */
    public function updateProductType(ProductTypeRequest $request, int $id): void
    {
        $acc = auth()->user()->productTypes;
        $productType = ProductType::find($id);

        $this->policy->can($acc, $productType, 'Product type');

        $productType->fill($request->validated());
        $productType->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteProductType(int $id): void
    {
        $acc = auth()->user()->productTypes;
        $productType = ProductType::find($id);

        $this->policy->can($acc, $productType, 'Product type');

        $productType->delete();
    }
}
