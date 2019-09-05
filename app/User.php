<?php

namespace App;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, Notifiable;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['role'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'promotion', 'email', 'password', 'role_id'
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
     * @param $value
     */
    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucwords(strtolower($value));
    }

    /**
     * Always fully capitalize the last name when we retrieve it
     * @param $value
     */
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = strtoupper($value);
    }

    /**
     * Get the user's borrowings
     */
    public function borrowings() {
        return $this->belongsTo('App\Borrowing', 'id', 'borrower_id');
    }

    /**
     * Get the user's lendings
     */
    public function lendings() {
        return $this->belongsTo('App\Borrowing', 'id', 'initial_lender_id');
    }

    /**
     * Get the user's role
     */
    public function role() {
        return $this->hasOne('App\UserRole', 'id', 'role_id')
            ->select('id', 'name_'.App::getLocale().' AS name');
    }

    /**
     * Scope a query to order by name.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public static function scopeOrderByName($query) {
        return $query
            ->orderBy('last_name')
            ->orderBy('first_name');
    }
}
