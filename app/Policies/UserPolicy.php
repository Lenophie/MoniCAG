<?php

namespace App\Policies;

use App\User;
use App\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->role_id == UserRole::ADMINISTRATOR;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function view(User $user, User $model)
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can update the role of the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function updateRole(User $user, User $model)
    {
        return $user->id == $model->id ||
            ($user->role_id == UserRole::ADMINISTRATOR && $model->role_id !== UserRole::ADMINISTRATOR);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function delete(User $user, User $model)
    {
        return $user->id == $model->id ||
            ($user->role_id == UserRole::ADMINISTRATOR && $model->role_id !== UserRole::ADMINISTRATOR);
    }
}
