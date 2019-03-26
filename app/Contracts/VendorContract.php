<?php

namespace App\Contracts;

use App\DTO\VendorDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\VendorRequest;

interface VendorContract
{
  public function getVendors(PagedRequest $request) : PagedResponse;
  public function findVendor(int $id) : VendorDTO;
  public function addVendor(VendorRequest $request);
  public function deleteVendor(int $id);
  public function updateVendor(VendorRequest $request, int $id);
}

