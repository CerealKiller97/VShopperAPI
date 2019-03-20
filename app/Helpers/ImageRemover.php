<?php

namespace App\Helpers;

use App\Models\Image;

class ImageRemover
{
  public static function remove($id)
  {
    // Find an image from DB
    $image = Image::find($id);
    // Delete image from DB
    $image->delete();
    // Remove file from server
    unlink(public_path('/') . $image->src);
  }
}
