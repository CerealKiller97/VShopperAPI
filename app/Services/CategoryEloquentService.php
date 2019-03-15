<?php

namespace App\Services;

use App\Models\Image;
use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Helpers\UploadFile;
use App\Helpers\ImageUpload;
use App\Contracts\CategoryContract;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\QueryException;
use App\Exceptions\EntityNotFoundException;

class CategoryEloquentService implements CategoryContract
{
  public function getCategories() : array
  {
    $default = Category::default()->get()->toArray();
    $acc = auth()->user()->categories->toArray();
    $categories = array_merge($default, $acc);

    $categoriesArr = [];
    foreach($categories as $category)
    {
      $categoryDTO = new CategoryDTO;

      $categoryDTO->id = $category['id'];
      $categoryDTO->name = $category['name'];
      $categoryDTO->subcategory_id = $category['subcategory_id'];

       $categoryDTO->image = ($category['image_id'])
         ? Image::find($category['image_id'])->src
         : null;

      $categoriesArr[] = $categoryDTO;
    }

    return ['data' => $categoriesArr];
  }

  public function findCategory(int $id) : CategoryDTO
  {
    $acc = auth()->user()->categories;
    $category = Category::find($id);

    $allowedToSee = $acc->filter(function ($value, $key) use ($category) {
      if ($category === null) {
        return [];
      }
      return $value->id === $category->id ?? [];
    });

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }
    // Category doesn't belong to auth user account but exists in DB
    if ((count($allowedToSee)=== 0) ) {
      throw new EntityNotFoundException('Category not found');
    }

    $categoryDTO = new CategoryDTO;

    $categoryDTO->id = $category->id;
    $categoryDTO->name = $category->name;
    $categoryDTO->subcategory_id = $category->subcategory_id;
    // Check if category has an image
     ($category->image)
     ? $categoryDTO->image = $category->image->src
     : $categoryDTO->image = $category->image;

    return $categoryDTO;
  }

  public function addCategory(CategoryRequest $request)
  {
    $src = UploadFile::move($request->image);

    $image_id = Image::create($src)->id;

    $category = Category::create([
      'name' => $request->name,
      'account_id' => auth()->user()->id,
      'subcategory_id' => $request->subcategory_id ?? null,
      'image_id' => $image_id
    ]);

  }

  public function updateCategory(CategoryRequest $request, int $id)
  {
    $acc = auth()->user()->categories;
    $category = Category::find($id);

    $allowedToUpdate = $acc->filter(function ($value, $key) use ($category) {
      if ($category === null) {
        return [];
      }
      return $value->id === $category->id ?? [];
    });

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }
    // Category doesn't belong to auth user account but exists in DB
    if ((count($allowedToUpdate)=== 0) ) {
      throw new EntityNotFoundException('Category not found');
    }

    $category->fill($request->validated());
    $category->save();
  }

  public function deleteCategory(int $id)
  {
    $acc = auth()->user()->categories;
    $category = Category::find($id);

    $allowedToDelete = $acc->filter(function ($value, $key) use ($category) {
      if ($category === null) {
        return [];
      }
      return $value->id === $category->id ?? [];
    });

    if (!$category) {
      throw new EntityNotFoundException('Category not found');
    }
    // Category doesn't belong to auth user account but exists in DB
    if ((count($allowedToDelete)=== 0) ) {
      throw new EntityNotFoundException('Category not found');
    }

    if ($category->image !== null) {
      unlink(public_path('/') . $category->image->src);
    }

    $category->delete();
  }

}
