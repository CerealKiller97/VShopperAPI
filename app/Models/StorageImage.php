<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageImage extends Model
{
  protected $fillable = [
      'storage_id',
      'image_id'
  ];

  public function storages()
  {
    return $this->belongsToMany(Storage::class);
  }

  public function images()
  {
    return $this->belongsToMany(Image::class);
  }
}
