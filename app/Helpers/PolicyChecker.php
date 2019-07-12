<?php

declare(strict_types=1);

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

  public function can($acc, $entityModel, string $error = 'Resource')
  {
    $allowedToSee = $acc->filter(function ($value, $key) use ($entityModel) {
      if ($entityModel === null) {
        return [];
      }
      return $value->id === $entityModel->id ?? [];
    });

    if (!$entityModel) {
      throw new EntityNotFoundException($error);
    }
    // Resource doesn't belong to auth user account but exists in DB
    if ((count($allowedToSee) === 0) ) {
      throw new EntityNotFoundException($error);
    }
  }

  /**
   * @function can
   * @param  {string} $tableName  Table name
   * @param  {array} $ids  Array of ids that we want to delete
   * @param  {string} $entityIdentifierColumn  Name of entitity's unique field
   * @param  {int} $id  ID  of entitity's unique field
   * @return { bool} {bool / Exception }
   */

    /**
     * @function canDeleteFromPivotTable
     * @param mixed $name
     * @throws Exception
     * @param string $tableName
     * @param array $ids
     * @param int $id
     * @param string $entityIdentifierColumn
     */

  public static function canDeleteFromPivotTable(string $tableName = "", array $ids = [],int $id, string $entityIdentifierColumn = "")
  {
    $countRow = \DB::table($tableName)
                          ->whereIn('image_id',  $ids)
                          ->where($entityIdentifierColumn, $id)
                          ->count();

    if ($countRow === count($ids)) {
      \DB::table($tableName)
           ->whereIn($entityIdentifierColumn, $ids)
           ->delete();
      // StorageImage::whereIn('image_id',  $imageIDS)->delete();
    } else {
      throw new Exception('Ne mere rodjak');
    }
  }
}
