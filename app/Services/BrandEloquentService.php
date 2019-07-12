<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\BrandDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\Brand;
use App\Helpers\PagedResponse;
use App\Contracts\BrandContract;
use App\Http\Requests\{
    BrandRequest,
    PagedRequest

};

class BrandEloquentService extends BaseService implements BrandContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getBrands(PagedRequest $request): PagedResponse
    {
        $page = $request->getPaging()->page;
        $perPage = $request->getPaging()->perPage;
        $name = $request->getPaging()->name;

        $brands = new Brand;
        $account_id = auth()->user()->id;

        $acc = $brands->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $perPage, $page, $name);
        $brandsCount = auth()->user()->brands->count();

        $pagesCount = (int) ceil($brandsCount / $perPage);

        $brandsArr = [];

        foreach ($items as $brand) {
            $brandDTO = new BrandDTO;

            $brandDTO->id = $brand->id;
            $brandDTO->name = $brand->name;

            $brandsArr[] = $brandDTO;
        }

        return new PagedResponse($brandsArr, $brandsCount, $page, $pagesCount);
    }

    /**
     * @param int $id
     *
     * @return BrandDTO
     * @throws EntityNotFoundException
     */
    public function findBrand(int $id): BrandDTO
    {
        $acc = auth()->user()->brands;
        $brand = Brand::find($id);

        $this->policy->can($acc, $brand, 'Brand');

        $brandDTO = new BrandDTO;

        $brandDTO->id = $brand->id;
        $brandDTO->name = $brand->name;

        return $brandDTO;
    }

    /**
     * @param BrandRequest $request
     */
    public function addBrand(BrandRequest $request): void
    {
        auth()->user()->brands()->create($request->validated());
    }

    /**
     * @param BrandRequest $request
     * @param int          $id
     *
     * @throws EntityNotFoundException
     */
    public function updateBrand(BrandRequest $request, int $id): void
    {
        $acc = auth()->user()->brands;
        $brand = Brand::find($id);

        $this->policy->can($acc, $brand, 'Brand');

        $brand->fill($request->validated());
        $brand->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteBrand(int $id): void
    {
        $acc = auth()->user()->brands;
        $brand = Brand::find($id);

        $this->policy->can($acc, $brand, 'Brand');

        $brand->delete();
    }
}
