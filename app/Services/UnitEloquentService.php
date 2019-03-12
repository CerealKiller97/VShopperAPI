<?php

namespace App\Services;

use App\DTO\UnitDTO;
use App\Models\Unit;
use App\Contracts\UnitContract;
use App\Http\Requests\UnitRequest;
use App\Exceptions\EntityNotFoundException;

class UnitEloquentService implements UnitContract
{
  public function getUnits() : array
  {
    $default = Unit::default()->get()->toArray();
    $acc = request()->user()->units->toArray();
    $units = array_merge($default, $acc);

    $unitsArr = [];
    foreach($units as $unit)
    {
      $unitDTO = new UnitDTO();

      $unitDTO->id = $unit['id'];
      $unitDTO->name = $unit['name'];
      $unitDTO->abbr = $unit['abbr'];
      // should I remove account_id?
      //$unitDTO->account_id = $unit['account_id'];

      $unitsArr[] = $unitDTO;
    }

    return $unitsArr;
  }

  public function findUnit(int $id) : UnitDTO
  {
    $unit = Unit::find($id);

    if (!$unit)
      throw new EntityNotFoundException('Unit not found');

    $unitDTO = new UnitDTO();

    $unitDTO->id = $unit->id;
    $unitDTO->name = $unit->name;
    $unitDTO->abbr = $unit->abbr;
    $unitDTO->account_id = $unit->account_id;

    return $unitDTO;
  }

  public function addUnit(UnitRequest $request)
  {
    Unit::create($request->validated());
  }

  public function updateUnit(UnitRequest $request, int $id)
  {
    $unit = Unit::find($id);
    if (!$unit) {
      throw new EntityNotFoundException('Unit not found');
    }
    $unit->fill($request->validated());
    $unit->save();
  }

  public function deleteUnit(int $id)
  {
    $unit = Unit::find($id);

    if (!$unit)
      throw new EntityNotFoundException('Unit not found');

    $unit->delete();
  }

}

