<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountGroup extends Model
{
    protected $fillable = [
        'discount_id',
        'group_id'
    ];

    public function discount()
    {
      return $this->belongsToMany(Discount::class);
    }

    public function group()
    {
      return $this->belongsToMany(Group::class);
    }
}
