<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\VendorDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\Vendors\{
    VendorRequest,
    VendorSearchRequest

};

interface VendorContract
{
    /**
     * @param VendorSearchRequest $request
     *
     * @return PagedResponse
     */
    public function getVendors(VendorSearchRequest $request): PagedResponse;

    /**
     * @param int $id
     *
     * @return VendorDTO
     */
    public function findVendor(int $id): VendorDTO;

    /**
     * @param VendorRequest $request
     */
    public function addVendor(VendorRequest $request): void;

    /**
     * @param int $id
     */
    public function deleteVendor(int $id): void;

    /**
     * @param VendorRequest $request
     * @param int           $id
     */
    public function updateVendor(VendorRequest $request, int $id): void;
}

