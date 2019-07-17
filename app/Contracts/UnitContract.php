<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\UnitDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\Units\{
    UnitRequest,
    UnitSearchRequest

};

interface UnitContract
{
    /**
     * @param UnitSearchRequest $request
     *
     * @return PagedResponse
     */
    public function getUnits(UnitSearchRequest $request): PagedResponse;

    /**
     * @param int $id
     *
     * @return UnitDTO
     */
    public function findUnit(int $id): UnitDTO;

    /**
     * @param UnitRequest $request
     */
    public function addUnit(UnitRequest $request): void;

    /**
     * @param UnitRequest $request
     * @param int         $id
     */
    public function updateUnit(UnitRequest $request, int $id): void;

    /**
     * @param int $id
     */
    public function deleteUnit(int $id): void;
}

