<?php

namespace App\Contracts;

use App\DTO\VendorDTO;
use App\Http\Requests\VendorRequest;

interface VendorContract
{
  public function getVendors() : array;
  public function findVendor(int $id) : VendorDTO;
  public function addVendor(VendorRequest $request);
  public function deleteVendor(int $id);
  public function updateVendor(VendorRequest $request, int $id);
}
