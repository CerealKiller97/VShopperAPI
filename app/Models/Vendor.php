<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'address',
        'pib',
        'phone',
        'email',
        'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
