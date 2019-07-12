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
    public function getStorageTypes(PagedRequest $request): PagedResponse;

    public function findStorageType(int $id): StorageTypeDTO;

    public function addStorageType(StorageTypeRequest $request): void;

    public function updateStorageType(StorageTypeRequest $request, int $id): void;

    public function deleteStorageType(int $id): void;
}

