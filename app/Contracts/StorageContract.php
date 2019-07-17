<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\StorageDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    StorageRequest,
    StorageSearchRequest

};

interface StorageContract
{
    /**
     * @param StorageSearchRequest $request
     *
     * @return PagedResponse
     */
    public function getStorages(StorageSearchRequest $request): PagedResponse;

    /**
     * @param int $id
     *
     * @return StorageDTO
     */
    public function findStorage(int $id): StorageDTO;

    /**
     * @param StorageRequest $request
     */
    public function addStorage(StorageRequest $request): void;

    /**
     * @param StorageRequest $request
     * @param int            $id
     */
    public function updateStorage(StorageRequest $request, int $id): void;

    /**
     * @param int $id
     */
    public function deleteStorage(int $id): void;
}

