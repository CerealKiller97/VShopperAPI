<?php

namespace App\Contracts;

use App\DTO\CategoryDTO;
use App\Http\Requests\CategoryRequest;

interface CategoryContract
{
  public function getCategories() : array;
  public function findCategory(int $id) : CategoryDTO;
  public function addCategory(CategoryRequest $request);
  public function updateCategory(CategoryRequest $request, int $id);
  public function deleteCategory(int $id);
}
