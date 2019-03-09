<?php

namespace App\Contracts;

use App\Http\Requests\CategoryRequest;

interface CategoryContract
{
  public function getCategories();
  public function addCategory(CategoryRequest $request);
  public function findCategory(int $id);
  public function deleteCategory(int $id);
  public function updateCategory(CategoryRequest $request, int $id);
  public function profileCategory();
}
