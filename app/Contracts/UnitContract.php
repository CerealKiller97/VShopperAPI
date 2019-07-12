<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\UnitDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\{
    UnitRequest,
    PagedRequest

};

interface UnitContract
{
    public function getUnits(PagedRequest $request): PagedResponse;

    public function findUnit(int $id): UnitDTO;

    public function addUnit(UnitRequest $request): void;

    public function updateUnit(UnitRequest $request, int $id): void;

    public function deleteUnit(int $id): void;
}

