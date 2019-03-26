<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const DEFAULT_CATEGORY_IDS = [1, 2, 3, 4, 5];

    protected $fillable = [
        'name',
        'account_id',
        'subcategory_id',
        'image_id'
    ];
    // // TMP SOLUTION
    // protected $hidden = [
    //   'created_at',
    //   'updated_at'
    // ];

    public function account()
    {
      return $this->belongsTo(Account::class);
    }

    public function subcategory()
    {
      return $this->hasMany(Category::class, 'subcategory_id', 'id');
    }

    public function category()
    {
      return $this->belongsTo(Category::class, 'subcategory_id', 'id');
    }

    public function image()
    {
      return $this->belongsTo(Image::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeDefault($query)
    {
      return $query->where('account_id', null);
    }
}
