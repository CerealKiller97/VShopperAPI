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
    $vendors = auth()->user()->vendors;
    $vendorsArr = [];

    foreach ($vendors as $vendor)
    {
      $vendorDTO = new VendorDTO();

      $vendorDTO->id = $vendor->id;
      $vendorDTO->name = $vendor->name;
      $vendorDTO->address = $vendor->address;
      $vendorDTO->pib = $vendor->pib;
      $vendorDTO->phone = $vendor->phone;
      $vendorDTO->email = $vendor->email;

      $vendorsArr[] = $vendorDTO;
    }

    return $vendorsArr;
  }

  public function findVendor(int $id) : VendorDTO
  {
    $vendor = Vendor::find($id);

    if (!$vendor) {
      throw new EntityNotFoundException('Vendor not found');
    }

    $vendorDTO = new VendorDTO();

    $vendorDTO->id = $vendor->id;
    $vendorDTO->name = $vendor->name;
    $vendorDTO->address = $vendor->address;
    $vendorDTO->pib = $vendor->pib;
    $vendorDTO->phone = $vendor->phone;
    $vendorDTO->email = $vendor->email;
    $vendorDTO->account_id = $vendor->account_id;

    return $vendorDTO;
  }

  public function addVendor(VendorRequest $request)
  {
    $vendor = Vendor::create($request->validated());
    request()->user()->vendors()->save($vendor);
  }

  public function updateVendor(VendorRequest $request, int $id)
  {

  }

  public function deleteVendor(int $id)
  {

  }
}

