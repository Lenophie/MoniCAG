<?php

namespace App\Policies;

use App\User;
use App\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any inventory items.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the inventory item.
     *
     * @param User $user
     * @return bool
     */
    public function view(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create inventory items.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->role_id == UserRole::ADMINISTRATOR;
    }

    /**
     * Determine whether the user can update the inventory item.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->role_id == UserRole::ADMINISTRATOR;
    }

    /**
     * Determine whether the user can delete the inventory item.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->role_id == UserRole::ADMINISTRATOR;
    }
}
