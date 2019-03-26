<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Discount;
use App\Models\DiscountGroup;

class DiscountChecker
{
  public static function valid($disocuntModel, int $groupID)
  {
    $validFrom = $disocuntModel->valid_from;
    $validFromDayOfYear = Carbon::parse($validFrom)->dayOfYear;
    $validUntil = $disocuntModel->valid_until;
    $validUntilDayOfYear = Carbon::parse($validUntil)->dayOfYear;
    $currentDate = Carbon::now()->dayOfYear;

    if ( ($currentDate >= $validFromDayOfYear)  && ($currentDate <= $validUntilDayOfYear) ) {
      return $disocuntModel->amount;
    } else {
      return null;
    }
  }
}
