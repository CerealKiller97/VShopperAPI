<?php

namespace App\Services;

use App\Models\Category;
use App\Helpers\ImageUpload;
use App\Contracts\CategoryContract;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\QueryException;
use App\Exceptions\EntityNotFoundException;

class CategoryEloquentService implements CategoryContract
{
  public function getCategories()
  {
    // Get default categories
    $default = Category::default()->get();
    // Get user's categories
    $acc = request()->user()->categories;
    $acc->push($default);
    // TODO: map to DTO
    return $acc;
  }

  public function addCategory(CategoryRequest $request)
  {
      //ImageUpload::upload();
      Category::create($request->validated());

  }

  public function findCategory(int $id)
  {
    $category = Category::find($id);

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }
    // TODO: map to DTO
    return $category;
  }

  public function deleteCategory(int $id)
  {
    $category = Category::find($id);

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }

    $category->delete();
  }

  public function updateCategory(CategoryRequest $request, int $id)
  {
    $category = Category::find($id);

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }

    $category->update(array_merge($request->validated(), [$id]));
  }

}
