<?php

namespace App\Services;

use App\DTO\UnitDTO;
use App\Models\Unit;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Contracts\UnitContract;
use App\Http\Requests\UnitRequest;
use App\Http\Requests\PagedRequest;

class UnitEloquentService extends BaseService implements UnitContract
{
  public function getUnits(PagedRequest $request) : PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $units = new Unit;
    $account_id =  auth()->user()->id;

    $acc = $units->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page, $name);

    $default = Unit::default()->get();

    $final = $default->merge($items);

    $unitsCount = $final->count();

    $unitsArr = [];

    foreach($final as $unit)
    {
      $unitDTO = new UnitDTO;

      $unitDTO->id = $unit['id'];
      $unitDTO->name = $unit['name'];
      $unitDTO->abbr = $unit['abbr'];

      $unitsArr[] = $unitDTO;
    }

    return new PagedResponse($unitsArr, $unitsCount, $page);
  }

  public function findUnit(int $id) : UnitDTO
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

  public function addUnit(UnitRequest $request)
  {
    $unit = Unit::create($request->validated());
    auth()->user()->units()->save($unit);
  }

  public function updateUnit(UnitRequest $request, int $id)
  {
    $acc = auth()->user()->units;
    $unit = Unit::find($id);

    $this->policy->can($acc, $unit, 'Unit');

    $unit->fill($request->validated());
    $unit->save();
  }

  public function deleteUnit(int $id)
  {
    $acc = auth()->user()->units;
    $unit = Unit::find($id);

    $this->policy->can($acc, $unit, 'Unit');

    $unit->delete();
  }

}

