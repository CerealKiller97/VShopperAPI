<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\StorageDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\StorageRequest;
use App\Http\Requests\StorageSearchRequest;

interface StorageContract
{
    public function getStorages(StorageSearchRequest $request): PagedResponse;

    public function findStorage(int $id): StorageDTO;

    public function addStorage(StorageRequest $request): void;

    public function updateStorage(StorageRequest $request, int $id): void;

    public function deleteStorage(int $id): void;
}

