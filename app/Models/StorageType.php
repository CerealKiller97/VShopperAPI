<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageType extends Model
{
    protected $fillable = ['name'];

    public function storages()
    {
        return $this->hasMany(Storage::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeDefault($query)
    {
        return $query->where('account_id', null);
    }
}
