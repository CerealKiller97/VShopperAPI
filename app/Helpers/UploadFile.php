<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Storage;

class UploadFile
{
  /**
   * @function upload
   * @param  {type} ImageRequest $request {description}
   * @return {type} {description}
   * @see 'images' replace it with your path
   */
  public static function move(UploadedFile $request) : string
  {
    $fileWithExtension = $request->getClientOriginalName();
    $fileName = pathinfo($fileWithExtension, PATHINFO_FILENAME);
    $extension = $request->guessClientExtension();

    $src = time() . $fileName . '.' .$extension;


    dd($request);


    // $slika = $request->file('slikaPosta');
    // $slikaIme = $slika->getClientOriginalName();

    // $name = time() . '_' . $src;

    //  //$slikaIme = time() . '_' . $slikaIme;
    //  $path = 'images/' . $name;
    // // $putanjaSlike = 'images/' . time() . '_' . $slikaIme;
    // // public_path('images');
    // Storage::move(path, target);
    // File::move($src, public_path('images'));
    //  $slika->move(public_path('images'), $slikaIme);
    // return $slikaIme;
  }

  public function store(Request $request)
  {
    $imageSrc = UploadFile::upload($request->file);
  }
}

