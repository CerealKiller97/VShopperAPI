<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\VendorDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\Vendor;
use App\Helpers\PagedResponse;
use App\Contracts\VendorContract;
use App\Http\Requests\{
    VendorRequest,
    PagedRequest

};

class VendorEloquentService extends BaseService implements VendorContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getVendors(PagedRequest $request): PagedResponse
    {
        $page = $request->getPaging()->page;
        $perPage = $request->getPaging()->perPage;
        $name = $request->getPaging()->name;

        $vendor = new Vendor;
        $account_id = auth()->user()->id;
        $acc = $vendor->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $perPage, $page, $name);
        $vendorsCount = auth()->user()->vendors->count();

        $pagesCount = (int) ceil($vendorsCount / $perPage);

        $vendorsArr = [];

        foreach ($items as $vendor) {
            $vendorDTO = new VendorDTO;

            $vendorDTO->id = $vendor->id;
            $vendorDTO->name = $vendor->name;
            $vendorDTO->address = $vendor->address;
            $vendorDTO->pib = $vendor->pib;
            $vendorDTO->phone = $vendor->phone;
            $vendorDTO->email = $vendor->email;

            $vendorsArr[] = $vendorDTO;
        }

        return new PagedResponse($vendorsArr, $vendorsCount, $page, $pagesCount);
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

        $vendorDTO->id = $vendor->id;
        $vendorDTO->name = $vendor->name;
        $vendorDTO->address = $vendor->address;
        $vendorDTO->pib = $vendor->pib;
        $vendorDTO->phone = $vendor->phone;
        $vendorDTO->email = $vendor->email;

        return $vendorDTO;
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
}

