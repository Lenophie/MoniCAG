<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Support\Facades\App;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'promotion', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Always capitalize the first letter of the first name when we retrieve it
     */
    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    /**
     * Always fully capitalize the last name when we retrieve it
     */
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }
}
