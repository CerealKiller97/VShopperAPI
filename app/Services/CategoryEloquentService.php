<?php

namespace App\Services;

use App\Models\Category;
use App\Contracts\CategoryContract;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\QueryException;
use App\Exceptions\EntityNotFoundException;

class CategoryEloquentService implements CategoryContract
{
  public function getCategories()
  {
    return Category::all();
  }

  public function addCategory(CategoryRequest $request)
  {
    try {
      Category::create($request->validated());
    } catch(QueryException $e) {
      throw new Exception("Server Error");
      \Log::error($e->getMessage());
    }
  }

  public function findCategory(int $id)
  {
    $category = Category::find($id);

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }

    return $category;
  }

  public function deleteCategory(int $id)
  {
    $category = Category::find($id);

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }

    // try {
      $category->delete();
    // } catch (\QueryException $e) {
      //throw $e;
    // }
  }

  public function updateCategory(CategoryRequest $request, int $id)
  {

  }

  public function profileCategory()
  {
    // Get default categories
    $default = Category::default()->get();
    // Get user's categories
    $acc = request()->user()->categories;
    $acc->push($default);
    // TODO: map to DTO
    return $acc;
  }

}
