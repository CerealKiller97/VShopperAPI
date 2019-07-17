<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UnitDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\Unit;
use App\Helpers\PagedResponse;
use App\Contracts\UnitContract;
use App\Http\Requests\Units\{
    UnitRequest,
    UnitSearchRequest

};

class UnitEloquentService extends BaseService implements UnitContract
{
    /**
     * @param UnitSearchRequest $request
     *
     * @return PagedResponse
     */
    public function getUnits(UnitSearchRequest $request): PagedResponse
    {
        $pagedRequest = $request->getPaging();

        $units = new Unit;
        $account_id = auth()->user()->id;

        $acc = $units->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $pagedRequest);

        $default = Unit::default()->get();

        $final = $default->merge($items);

        $unitsCount = $final->count();

        $pagesCount = (int) ceil($unitsCount / $pagedRequest->perPage);

        $unitsArr = [];

        foreach ($final as $unit) {
            $unitDTO = new UnitDTO;

            $unitDTO->id = $unit['id'];
            $unitDTO->name = $unit['name'];
            $unitDTO->abbr = $unit['abbr'];

            $unitsArr[] = $unitDTO;
        }

        return new PagedResponse($unitsArr, $unitsCount, $pagedRequest->page, $pagesCount);
    }

    /**
     * @param int $id
     *
     * @return UnitDTO
     * @throws EntityNotFoundException
     */
    public function findUnit(int $id): UnitDTO
    {
        $acc = auth()->user()->units;
        $unit = Unit::find($id);

        $this->policy->can($acc, $unit, 'Unit');

        $unitDTO = new UnitDTO;

        $unitDTO->id = $unit->id;
        $unitDTO->name = $unit->name;
        $unitDTO->abbr = $unit->abbr;

        return $unitDTO;
    }

    /**
     * @param UnitRequest $request
     */
    public function addUnit(UnitRequest $request): void
    {
        $unit = Unit::create($request->validated());
        auth()->user()->units()->save($unit);
    }

    /**
     * @param UnitRequest $request
     * @param int         $id
     *
     * @throws EntityNotFoundException
     */
    public function updateUnit(UnitRequest $request, int $id): void
    {
        $acc = auth()->user()->units;
        $unit = Unit::find($id);

        $this->policy->can($acc, $unit, 'Unit');

        $unit->fill($request->validated());
        $unit->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteUnit(int $id): void
    {
        $acc = auth()->user()->units;
        $unit = Unit::find($id);

        $this->policy->can($acc, $unit, 'Unit');

        $unit->delete();
    }
}

