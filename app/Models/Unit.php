<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
  protected $fillable = [
    'name',
    'abbr',
    'account_id'
  ];

  public function account()
  {
    return $this->belongsTo(Account::class);
  }
}
