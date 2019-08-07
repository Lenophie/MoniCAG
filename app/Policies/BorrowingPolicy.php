<?php

namespace App\Policies;

use App\User;
use App\Borrowing;
use App\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class BorrowingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any borrowings.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->role_id == UserRole::LENDER || $user->role_id == UserRole::ADMINISTRATOR;
    }

    /**
     * Determine whether the user can view the borrowing.
     *
     * @param User $user
     * @param Borrowing $borrowing
     * @return bool
     */
    public function view(User $user, Borrowing $borrowing)
    {
        return $borrowing->borrower_id == $user->role_id ||
            $borrowing->initial_lender_id == $user->role_id ||
            $borrowing->return_lender_id == $user->role_id;
    }

    /**
     * Determine whether the user can create borrowings.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->role_id == UserRole::LENDER || $user->role_id == UserRole::ADMINISTRATOR;
    }

    /**
     * Determine whether the user can return the borrowing.
     *
     * @param User $user
     * @return bool
     */
    public function return(User $user)
    {
        return $user->role_id == UserRole::LENDER || $user->role_id == UserRole::ADMINISTRATOR;
    }
}
