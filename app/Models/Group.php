<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  protected $fillable = [
      'name',
      'account_id'
  ];

  public function account()
  {
    return $this->belongsTo(Account::class);
  }

  public function discounts()
  {
    return $this->belongsTo(Account::class);
  }

  public function scopeDefault($query)
  {
    return $query->where('account_id', null);
  }
}
