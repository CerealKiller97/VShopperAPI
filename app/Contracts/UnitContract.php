<?php

namespace App\Contracts;

use App\DTO\UnitDTO;
use App\Http\Requests\UnitRequest;

interface UnitContact
{
  public function getAllUnits();
  public function findUnit(int $id);
  public function addUnit(UnitRequest $request);
  public function updateUnit(UnitRequest $request, int $id);
  public function removeProduct(int $id);
}
