<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

class DiscountChecker
{
  public static function valid($disocuntModel, int $groupID = null): ?int
  {
    $validFrom = $disocuntModel->valid_from;
    $validFromDayOfYear = Carbon::parse($validFrom)->dayOfYear;
    $validUntil = $disocuntModel->valid_until;
    $validUntilDayOfYear = Carbon::parse($validUntil)->dayOfYear;
    $currentDate = Carbon::now()->dayOfYear;

    if (($currentDate >= $validFromDayOfYear) && ($currentDate <= $validUntilDayOfYear)) {
      return $disocuntModel->amount;
    } else {
      return null;
    }
  }
}
