<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'account_id',
        'category_id',
        'image_id'
    ];

    public function account()
    {
      return $this->belongsTo(Account::class);
    }

    // public function category()
    // {
    //   return $this->hasMany(Category::class, 'category_id', 'id');
    // }
}
