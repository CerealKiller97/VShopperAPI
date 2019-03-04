<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $fillable = ['src'];

  public function account()
  {
    return $this->belongsTo(Account::class, 'id');
  }

}
