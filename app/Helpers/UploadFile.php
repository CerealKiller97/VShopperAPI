<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UploadFile
{
  /**
   * @function upload
   * @param  {type} ImageRequest $request {description}
   * @return {type} {description}
   * @see 'images' replace it with your path
   */
  public static function move(UploadedFile $request) : array
  {
    $fileWithExtension = $request->getClientOriginalName();
    $fileName = pathinfo($fileWithExtension, PATHINFO_FILENAME);
    $extension = $request->guessClientExtension();

    $src = time() . $fileName . '.' . $extension;

    $path = 'images/' . $src;

    $request->move(public_path('images'), $path);

    return ['src' => $path];
  }

}
