<?php

namespace App\Services;

use App\DTO\VendorDTO;
use App\Models\Vendor;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Helpers\PolicyChecker;
use App\Contracts\VendorContract;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\VendorRequest;

class VendorEloquentService extends BaseService implements VendorContract
{
  public function getVendors(PagedRequest $request) : PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $vendor = new Vendor;
    $account_id =  auth()->user()->id;
    $acc = $vendor->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page, $name);
    $vendorsCount = auth()->user()->vendors->count();

    $vendorsArr = [];

    foreach ($items as $vendor)
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

    return new PagedResponse($vendorsArr, $vendorsCount, $page);
  }

  public function findVendor(int $id) : VendorDTO
  {
    $acc = auth()->user()->vendors;
    $vendor = Vendor::find($id);

    $this->policy->can($acc, $vendor, 'Vendor');

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

    $this->policy->can($acc, $vendor, 'Vendor');

    $vendor->fill($request->validated());
    $vendor->save();
  }

  public function deleteVendor(int $id)
  {
    $acc = auth()->user()->vendors;
    $vendor = Vendor::find($id);

    $this->policy->can($acc, $vendor, 'Vendor');

    $vendor->delete();
  }
}

