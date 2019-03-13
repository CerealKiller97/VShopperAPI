<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = ['address', 'size', 'storage_type_id', 'account_id'];


    public function type()
    {
      return $this->belongsTo(StorageType::class);
    }

    public function account()
    {
      return $this->belongsTo(Account::class);
    }
}
