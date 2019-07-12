<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\EntityNotFoundException;
use App\Models\Image;
use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Helpers\{
    UploadFile,
    PagedResponse

};
use App\Contracts\CategoryContract;
use App\Http\Requests\{
    PagedRequest,
    CategoryRequest

};

class CategoryEloquentService extends BaseService implements CategoryContract
{
    /**
     * @param PagedRequest $request
     *
     * @return PagedResponse
     */
    public function getCategories(PagedRequest $request): PagedResponse
    {
        $page = $request->getPaging()->page;
        $perPage = $request->getPaging()->perPage;
        $name = $request->getPaging()->name;

        $categories = new Category;
        $account_id = auth()->user()->id;

        $acc = $categories->where('account_id', $account_id);
        $items = $this->generatePagedResponse($acc, $perPage, $page, $name);

        $default = Category::default()->get();

        $final = $default->merge($items);

        $categoriesCount = $final->count();

        $pagesCount = (int) ceil($categoriesCount / $perPage);

        $categoriesArr = [];

        foreach ($final as $category) {
            $categoryDTO = new CategoryDTO;

            $categoryDTO->id = $category->id;
            $categoryDTO->name = $category->name;
            $categoryDTO->subcategory_id = $category->subcategory_id;
            $categoryDTO->image = $category->image->src ?? null;

            $categoriesArr[] = $categoryDTO;
        }

        return new PagedResponse($categoriesArr, $categoriesCount, $page, $pagesCount);
    }

    /**
     * @param int $id
     *
     * @return CategoryDTO
     * @throws EntityNotFoundException
     */
    public function findCategory(int $id): CategoryDTO
    {
        $acc = auth()->user()->categories;
        $category = Category::find($id);

        $this->policy->can($acc, $category, 'Category');

        $categoryDTO = new CategoryDTO;

        $categoryDTO->id = $category->id;
        $categoryDTO->name = $category->name;
        $categoryDTO->subcategory_id = $category->subcategory_id;
        // Check if category has an image
        ($category->image) ? $categoryDTO->image = $category->image->src : $categoryDTO->image = $category->image;

        return $categoryDTO;
    }

    /**
     * @param CategoryRequest $request
     */
    public function addCategory(CategoryRequest $request): void
    {
        if ($request->image) {
            $src = UploadFile::move($request->image);
            $image_id = Image::create($src)->id;
        }

        $category = Category::create(['name' => $request->name, 'account_id' => auth()->user()->id, 'subcategory_id' => $request->subcategory_id ?? null, 'image_id' => $image_id ?? null]);

    }

    /**
     * @param CategoryRequest $request
     * @param int             $id
     *
     * @throws EntityNotFoundException
     */
    public function updateCategory(CategoryRequest $request, int $id): void
    {
        $acc = auth()->user()->categories;
        $category = Category::find($id);

        $this->policy->can($acc, $category, 'Category');

        $category->fill($request->validated());
        $category->save();
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function deleteCategory(int $id): void
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
