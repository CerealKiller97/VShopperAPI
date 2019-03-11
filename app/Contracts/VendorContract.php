<?php

namespace App\Contracts;

use App\DTO\VendorDTO;
use App\Http\Requests\VendorRequest;

interface VendorContract
{
  public function getVendors() : array;
  public function findVendor(int $id) : VendorDTO;
  public function addVendor(VendorRequest $request);
  public function deleteCategory(int $id);
  public function updateCategory(VendorRequest $request, int $id);
}
