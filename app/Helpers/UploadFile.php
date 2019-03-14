<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\ImageRequest;

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
    dd($request);
    // $slika = $request->file('slikaPosta');
    // $slikaIme = $slika->getClientOriginalName();

    // $slikaIme = time() . '_' . $slikaIme;
    // $putanjaSlike = 'images/' . time() . '_' . $slikaIme;
    // public_path('images');

    // $slika->move(public_path('images'), $slikaIme);
    // return $slikaIme; // images/
  }

  public function store(Request $request)
  {
    $imageSrc = UploadFile::upload($request->file);
  }
}

