<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CategoryDTO;
use App\Helpers\PagedResponse;
use App\Http\Requests\PagedRequest;
use App\Http\Requests\CategoryRequest;

interface CategoryContract
{
    public function getCategories(PagedRequest $request): PagedResponse;

    public function findCategory(int $id): CategoryDTO;

    public function addCategory(CategoryRequest $request): void;

    public function updateCategory(CategoryRequest $request, int $id): void;

    public function deleteCategory(int $id): void;
}

