<?php

namespace App\Services;

use App\Models\Image;
use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Helpers\UploadFile;
use App\Services\BaseService;
use App\Helpers\PagedResponse;
use App\Contracts\CategoryContract;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\CategoryRequest;

class CategoryEloquentService extends BaseService implements CategoryContract
{
  public function getCategories(PagedRequest $request) : PagedResponse
  {
    $page = $request->getPaging()->page;
    $perPage = $request->getPaging()->perPage;
    $name = $request->getPaging()->name;

    $categories = new Category;
    $account_id =  auth()->user()->id;

    $acc = $categories->where('account_id', $account_id);
    $items = $this->generatePagedResponse($acc, $perPage, $page, $name)->toArray();
    $categoriesCount = auth()->user()->categories->count();


    $categoriesArr = [];
    foreach($items as $category)
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

    return new PagedResponse($categoriesArr, $categoriesCount, $page);
  }

  public function findCategory(int $id) : CategoryDTO
  {
    $acc = auth()->user()->categories;
    $category = Category::find($id);

    $this->policy->can($acc, $category, 'Category');

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

    $this->policy->can($acc, $category, 'Category');

    $category->fill($request->validated());
    $category->save();
  }

  public function deleteCategory(int $id)
  {
    $acc = auth()->user()->categories;
    $category = Category::find($id);

    $this->policy->can($acc, $category, 'Category');

    if ($category->image !== null) {
      unlink(public_path('/') . $category->image->src);
    }
    $category->delete();
    Image::destroy($category->image_id);
  }
}
