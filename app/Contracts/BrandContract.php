<?php

namespace App\Contracts;

use App\DTO\BrandDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\PagedRequest;

interface BrandContract
{
  public function getBrands(PagedRequest $request) : PagedResponse;
  public function findBrand(int $id) : BrandDTO;
  public function addBrand(BrandRequest $request);
  public function updateBrand(BrandRequest $request, int $id);
  public function deleteBrand(int $id);
}
