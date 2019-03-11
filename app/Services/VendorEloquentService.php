<?php

namespace App\Services;

use App\DTO\VendorDTO;
use App\Contracts\VendorContract;
use App\Http\Requests\VendorRequest;

class VendorEloquentService implements VendorContract
{
  public function getVendors() : array
  {

  }

  public function findVendor(int $id) : VendorDTO
  {

  }

  public function addVendor(VendorRequest $request)
  {

  }

  public function deleteCategory(int $id)
  {

  }

  public function updateCategory(VendorRequest $request, int $id)
  {

  }

}

