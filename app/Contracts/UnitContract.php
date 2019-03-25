<?php

namespace App\Contracts;

use App\DTO\UnitDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\UnitRequest;
use App\Http\Requests\PagedRequest;

interface UnitContract
{
  public function getUnits(PagedRequest $request) : PagedResponse;
  public function findUnit(int $id) : UnitDTO;
  public function addUnit(UnitRequest $request);
  public function updateUnit(UnitRequest $request, int $id);
  public function deleteUnit(int $id);
}

