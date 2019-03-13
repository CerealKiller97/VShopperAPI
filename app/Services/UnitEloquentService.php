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
    $unit = Unit::find($id);

    if (!$unit)
      throw new EntityNotFoundException('Unit not found');

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

    if (!$unit) {
      throw new EntityNotFoundException('Unit not found');
    }

    $unit->delete();
  }

}

