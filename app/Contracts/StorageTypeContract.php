<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\StorageTypeDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    PagedRequest,
    StorageTypeRequest

};

interface StorageTypeContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getStorageTypes(PagedRequest $request): PagedResponse;

    /**
     * @param int $id
     *
     * @return StorageTypeDTO
     */
    public function findStorageType(int $id): StorageTypeDTO;

    /**
     * @param StorageTypeRequest $request
     */
    public function addStorageType(StorageTypeRequest $request): void;

    /**
     * @param StorageTypeRequest $request
     * @param int                $id
     */
    public function updateStorageType(StorageTypeRequest $request, int $id): void;

    /**
     * @param int $id
     */
    public function deleteStorageType(int $id): void;
}

