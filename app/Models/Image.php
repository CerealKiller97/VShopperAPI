<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $fillable = ['src'];

  public function account()
  {
    return $this->hasMany(Account::class);
  }

  // public function storages()
  // {
  //   return $this->belongsToMany(StorageImage::class);
  // }
}
