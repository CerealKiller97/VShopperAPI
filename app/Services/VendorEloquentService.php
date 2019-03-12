<?php

namespace App\Services;

use App\DTO\VendorDTO;
use App\Models\Vendor;
use App\Contracts\VendorContract;
use App\Http\Requests\VendorRequest;

class VendorEloquentService implements VendorContract
{
  public function getVendors() : array
  {

    return request()->user()->vendors->toArray();
  }

  public function findVendor(int $id) : VendorDTO
  {

  }

  public function addVendor(VendorRequest $request)
  {
    Vendor::create($request->validated());
  }

  public function deleteCategory(int $id)
  {

  }

  public function updateCategory(VendorRequest $request, int $id)
  {

  }

}

