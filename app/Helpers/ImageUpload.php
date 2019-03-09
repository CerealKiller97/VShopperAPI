<?php

namespace App\Helpers;

use App\Http\Requests\ImageRequest;

class ImageUpload
{
  public static function upload(ImageRequest $request)
  {
    //     $slika = $request->file('slikaPosta');
    //     $slikaIme = $slika->getClientOriginalName();

    //     $slikaIme = time()."_".$slikaIme;
    //     $putanjaSlike = "img/".time()."_".$slikaIme;
    //     public_path("img");

    //     try{
    //         $slika->move(public_path("img"),$slikaIme);
     dd($request->validated());
    //     } catch(QueryException $e) {

    //     }
  }
}
