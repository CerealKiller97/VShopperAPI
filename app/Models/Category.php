<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'account_id',
        'subcategory_id',
        'image_id'
    ];
    // TMP SOLUTION
    protected $hidden = [
      'created_at',
      'updated_at'
    ];

    public function account()
    {
      return $this->belongsTo(Account::class);
    }

    public function category()
    {
      return $this->hasMany(Category::class, 'subcategory_id', 'category_id');
    }

    public function image()
    {
      return $this->belongsTo(Image::class);
    }

    public function scopeDefault($query)
    {
        return $query->where('account_id', null);
    }
}
