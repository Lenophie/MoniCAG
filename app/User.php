<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        $this->attributes['first_name'] = ucwords(strtolower($value));
    }

    /**
     * Always fully capitalize the last name when we retrieve it
     */
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = strtoupper($value);
    }

    /**
     * Get the user's borrowings.
     */
    public function borrowings() {
        return $this->belongsTo('App\Borrowing', 'id', 'borrower_id');
    }
}
