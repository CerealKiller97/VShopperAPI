<?php

namespace App\Services;

use App\DTO\VendorDTO;
use App\Models\Vendor;
use App\Contracts\VendorContract;
use App\Http\Requests\VendorRequest;
use App\Exceptions\EntityNotFoundException;

class VendorEloquentService implements VendorContract
{
  public function getVendors() : array
  {
    $vendors = auth()->user()->vendors;
    $vendorsArr = [];

    foreach ($vendors as $vendor)
    {
      $vendorDTO = new VendorDTO;

      $vendorDTO->id = $vendor->id;
      $vendorDTO->name = $vendor->name;
      $vendorDTO->address = $vendor->address;
      $vendorDTO->pib = $vendor->pib;
      $vendorDTO->phone = $vendor->phone;
      $vendorDTO->email = $vendor->email;

      $vendorsArr[] = $vendorDTO;
    }

    return ['data' => $vendorsArr];
  }

  public function findVendor(int $id) : VendorDTO
  {
    $acc = auth()->user()->vendors;
    $vendor = Vendor::find($id);

    $allowedToSee = $acc->filter(function ($value, $key) use ($vendor) {
      if ($vendor === null) {
        return [];
      }
      return $value->id === $vendor->id ?? [];
    });

    if (!$vendor) {
      throw new EntityNotFoundException('Vendor not found');
    }
    // Vendor doesn't belong to auth user account but exists in DB
    if ((count($allowedToSee)=== 0) ) {
      throw new EntityNotFoundException('Vendor not found');
    }

    $vendorDTO = new VendorDTO;

    $vendorDTO->id = $vendor->id;
    $vendorDTO->name = $vendor->name;
    $vendorDTO->address = $vendor->address;
    $vendorDTO->pib = $vendor->pib;
    $vendorDTO->phone = $vendor->phone;
    $vendorDTO->email = $vendor->email;

    return $vendorDTO;
  }

  public function addVendor(VendorRequest $request)
  {
    auth()->user()->vendors()->create($request->validated());
  }

  public function updateVendor(VendorRequest $request, int $id)
  {
    $acc = auth()->user()->vendors;
    $vendor = Vendor::find($id);

    $allowedToSee = $acc->filter(function ($value, $key) use ($vendor) {
      if ($vendor === null) {
        return [];
      }
      return $value->id === $vendor->id ?? [];
    });

    if (!$vendor) {
      throw new EntityNotFoundException('Vendor not found');
    }
    // Vendor doesn't belong to auth user account but exists in DB
    if ((count($allowedToSee)=== 0) ) {
      throw new EntityNotFoundException('Vendor not found');
    }

    $vendor->fill($request->validated());
    $vendor->save();
  }

  public function deleteVendor(int $id)
  {
    $acc = auth()->user()->vendors;
    $vendor = Vendor::find($id);

    $allowedToSee = $acc->filter(function ($value, $key) use ($vendor) {
      if ($vendor === null) {
        return [];
      }
      return $value->id === $vendor->id ?? [];
    });

    if (!$vendor) {
      throw new EntityNotFoundException('Vendor not found');
    }
    // Vendor doesn't belong to auth user account but exists in DB
    if ((count($allowedToSee)=== 0) ) {
      throw new EntityNotFoundException('Vendor not found');
    }

    $vendor->delete();
  }
}

