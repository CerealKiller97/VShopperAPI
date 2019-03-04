<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'token',
        'image_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function vendors()
    {
      return $this->hasMany(Vendor::class);
    }

    public function scopeActive($query)
    {
        return $query->where('email_verified_at', '!=' ,null);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setTokenAttribute()
    {
        $this->attributes['token'] = bin2hex(random_bytes(60));
    }

}