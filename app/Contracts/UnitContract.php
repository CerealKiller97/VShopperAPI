<?php

namespace App\Contracts;

use App\DTO\UnitDTO;
use App\Http\Requests\UnitRequest;

interface UnitContract
{
  public function getUnits() : array;
  public function findUnit(int $id) : UnitDTO;
  public function addUnit(UnitRequest $request);
  public function updateUnit(UnitRequest $request, int $id);
  public function deleteUnit(int $id);
}
