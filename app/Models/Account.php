<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use HasApiTokens,Notifiable;

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
        return $this->hasOne(Image::class);
    }

    public function scopeActive($query)
    {
        return $query->where('email_verified_at', '!=' ,null);
    }

    // public function scopeLogin($query, $email, $password)
    // {
    //     return (bool) ($query->where([
    //         ['email', '=', $email],
    //         ['password', '=', bcrypt($password)]
    //     ])->count() === 1);
    // }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setTokenAttribute()
    {
        $this->attributes['token'] = bin2hex(random_bytes(60));
    }

}
