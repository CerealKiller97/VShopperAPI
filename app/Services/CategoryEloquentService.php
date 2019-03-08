<?php

namespace App\Services;

use App\Models\Category;
use App\Contracts\CategoryContract;

class CategoryEloquentService implements CategoryContract
{
  public function getCategories()
  {
    return Category::all();
  }

  public function addCategory()
  {

  }
}
