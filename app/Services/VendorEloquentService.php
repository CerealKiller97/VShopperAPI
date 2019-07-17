<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\VendorDTO;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\PagedRequest;
use App\Models\Vendor;
use App\Helpers\PagedResponse;
use App\Contracts\VendorContract;
use App\Http\Requests\Vendors\{
    VendorRequest,
    VendorSearchRequest

};

class VendorEloquentService extends BaseService implements VendorContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getVendors(VendorSearchRequest $request): PagedResponse
    {
        $pagedRequest = $request->getPaging();

        $vendor = new Vendor;

        $account_id = auth()->user()->id;
        $acc = $vendor->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $pagedRequest);
        $vendorsCount = auth()->user()->vendors->count();

        $pagesCount = (int) ceil($vendorsCount / $pagedRequest->perPage);

        $vendorsArr = [];

        foreach ($items as $vendor) {
            $vendorDTO = new VendorDTO;

            $dto = $this->mapDTO($vendorDTO, $vendor);

            $vendorsArr[] = $dto;
        }

        return new PagedResponse($vendorsArr, $vendorsCount, $pagedRequest->page, $pagesCount);
    }

    /**
     * @param int $id
     *
     * @return VendorDTO
     * @throws EntityNotFoundException
     */
    public function findVendor(int $id): VendorDTO
    {
        $acc = auth()->user()->vendors;
        $vendor = Vendor::find($id);

        $this->policy->can($acc, $vendor, 'Vendor');

        $vendorDTO = new VendorDTO;

        $dto = $this->mapDTO($vendorDTO, $vendor);

        return $dto;
    }

    /**
     * @param VendorRequest $request
     */
    public function addVendor(VendorRequest $request): void
    {
        auth()->user()->vendors()->create($request->validated());
    }

    /**
     * @param VendorRequest $request
     * @param int           $id
     *
     * @throws EntityNotFoundException
     */
    public function updateVendor(VendorRequest $request, int $id): void
    {
        $acc = auth()->user()->vendors;
        $vendor = Vendor::find($id);

        $this->policy->can($acc, $vendor, 'Vendor');

        $vendor->fill($request->validated());
        $vendor->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteVendor(int $id): void
    {
        $acc = auth()->user()->vendors;
        $vendor = Vendor::find($id);

        $this->policy->can($acc, $vendor, 'Vendor');

        $vendor->delete();
    }

    private function mapDTO(VendorDTO $vendorDTO, $vendor)
    {
        $vendorDTO->id = $vendor->id;
        $vendorDTO->name = $vendor->name;
        $vendorDTO->address = $vendor->address;
        $vendorDTO->pib = $vendor->pib;
        $vendorDTO->phone = $vendor->phone;
        $vendorDTO->email = $vendor->email;

        return $vendorDTO;
    }
}

