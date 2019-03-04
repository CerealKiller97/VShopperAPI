<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountGroup extends Model
{
    protected $fillable = [
        'discount_id',
        'group_id'
    ];
}
