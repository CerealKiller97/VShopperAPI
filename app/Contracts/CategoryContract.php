<?php

namespace App\Contracts;

interface CategoryContract
{
  public function getCategories();
  public function addCategory();
  public function findCategory(int $id);
  public function deleteCategory(int $id);
  public function updateCategory(int $id);
}
