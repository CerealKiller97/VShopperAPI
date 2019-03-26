<?php

namespace App\Helpers;

class PagedResponse
{
  public $data;
  public $total;
  public $currentPage;

  public function __construct(array $data, int $total, int $currentPage = null, int $pagesNumber = null)
  {
    $this->data = $data;
    $this->total = $total;
    $this->currentPage = $currentPage;
  }

}
