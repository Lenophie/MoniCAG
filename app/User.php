<?php

namespace App;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, Notifiable;

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

    /**
     * Get the user's lendings.
     */
    public function lendings() {
        return $this->belongsTo('App\Borrowing', 'id', 'initial_lender_id');
    }

    public function role() {
        return $this->hasOne('App\UserRole', 'id', 'role_id')
            ->select('id', 'name_'.App::getLocale().' AS name');
    }

    public static function allSelected() {
        $users = User::with('role')
            ->select(
                'id',
                'first_name AS firstName',
                'last_name AS lastName',
                'promotion',
                'email',
                'role_id')
            ->orderBy('role_id', 'desc')
            ->orderBy('promotion', 'desc')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();

        foreach($users as $user) {
            unset($user->role_id);
        }
        return $users;
    }

    public static function findWithBorrowingHistory($id) {
        $user = User::with('role', 'borrowings')
            ->where('id', $id)
            ->select(
                'id',
                'first_name AS firstName',
                'last_name AS lastName',
                'promotion',
                'email',
                'role_id')
            ->get();
        unset($user->role_id);
        return $user;
    }
}
