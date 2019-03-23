<?php

namespace App\Helpers;

use App\Exceptions\BatchDeleteException;

class ImagePivotTableRemover
{
  public static function remove(string $tableName, array $ids, int $id)
  {
    // Get identifier column by table name
    $whereIdentiierColumn = explode('_', $tableName)[1] . '_id';

    $images = \DB::table($tableName)
                   ->whereIn('image_id', $ids)
                   ->where($whereIdentiierColumn, $id)
                   ->count();

    if ($images === count($ids)) {
      \DB::table($tableName)
                   ->whereIn('image_id', $ids)
                   ->delete();
      // StorageImage::whereIn('image_id',  $ids)->delete();
    } else {
      throw new BatchDeleteException('One of ids is not valid');
    }
  }
}
