<?php

namespace App\Services;

use App\DTO\UnitDTO;
use App\Models\Unit;
use App\Services\BaseService;
use App\Contracts\UnitContract;
use App\Http\Requests\UnitRequest;

class UnitEloquentService extends BaseService implements UnitContract
{
  public function getUnits() : array
  {
    $default = Unit::default()->get()->toArray();
    $acc = auth()->user()->units->toArray();
    $units = array_merge($default, $acc);

    $unitsArr = [];
    foreach($units as $unit)
    {
      $unitDTO = new UnitDTO;

      $unitDTO->id = $unit['id'];
      $unitDTO->name = $unit['name'];
      $unitDTO->abbr = $unit['abbr'];

      $unitsArr[] = $unitDTO;
    }

    return ['data' => $unitsArr];
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

