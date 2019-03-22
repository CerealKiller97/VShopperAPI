<?php

namespace App\Helpers;

use App\Exceptions\EntityNotFoundException;

class PolicyChecker // a.k.a PolicyChecker
{

  // TODO: maybe create BaseService that contains PolicyChecker and change to normal function instead of static ???

  // logic to avoid repetition for policy finding resources that don't belong to us
  /**
   * @function can
   * @param  {type} $acc         { User resources units,brands ..etc }
   * @param  {type} $entityModel { Model resource }
   * @param  {type} $error       { Entity model error }
   * @return {type} {description}
   */
  // brands auth()->user->[brands]

  public function can($acc, $entityModel, $error = 'Resource')
  {
    $allowedToSee = $acc->filter(function ($value, $key) use ($entityModel) {
      if ($entityModel === null) {
        return [];
      }
      return $value->id === $entityModel->id ?? [];
    });

    if (!$entityModel) {
      throw new EntityNotFoundException("$error not found");
    }
    // Resource doesn't belong to auth user account but exists in DB
    if ((count($allowedToSee)=== 0) ) {
      throw new EntityNotFoundException("$error not found");
    }
  }

  public static function canDeleteFromPivotTable(array $ids, $id)
  {
    $images = StorageImage::whereIn('image_id',  $ids)
                          ->where('storage_id', $id)
                          ->count();

    if ($images === count($ids)) {
      StorageImage::whereIn('image_id',  $imageIDS)->delete();
    } else {
      throw new Exception('Ne mere rodjak');
    }
  }
}
