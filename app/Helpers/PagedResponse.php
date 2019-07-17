<?php

namespace App\Helpers;

class PagedResponse
{
  public $data;
  public $total;
  public $currentPage;
  public $pagesCount;

  public function __construct(array $data = [], int $total = null, int $currentPage = null, int $pagesCount = null)
  {
    $this->data = $data;
    $this->total = $total;
    $this->currentPage = $currentPage;
    $this->pagesCount = $pagesCount;
  }
}
