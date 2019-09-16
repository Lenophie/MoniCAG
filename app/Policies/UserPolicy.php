<?php

namespace App\Policies;

use App\User;
use App\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
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
        return $user->role_id == UserRole::ADMINISTRATOR || $user->role_id == UserRole::SUPER_ADMINISTRATOR;
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
     * @throws AuthorizationException
     */
    public function updateRole(User $user, User $model)
    {
        if ($user->id == $model->id && $user->role_id != UserRole::SUPER_ADMINISTRATOR) return true;
        else if ($user->role_id == UserRole::ADMINISTRATOR) {
            if ($model->role_id == UserRole::ADMINISTRATOR)
                $this->deny(__('validation/updateUserRole.user.unchanged_if_other_admin'));
            else if ($model->role_id == UserRole::LENDER || $model->role_id == UserRole::NONE)
                return true;
        } else if ($user->role_id == UserRole::SUPER_ADMINISTRATOR
                && ($model->role_id == UserRole::ADMINISTRATOR ||
                    $model->role_id == UserRole::LENDER ||
                    $model->role_id == UserRole::NONE))
                return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     * @throws AuthorizationException
     */
    public function delete(User $user, User $model)
    {
        if ($user->id == $model->id && $user->role_id != UserRole::SUPER_ADMINISTRATOR) return true;
        else if ($user->role_id == UserRole::ADMINISTRATOR) {
            if ($model->role_id == UserRole::ADMINISTRATOR)
                $this->deny(__('validation/deleteUser.user.unchanged_if_other_admin'));
            else if ($model->role_id == UserRole::LENDER || $model->role_id == UserRole::NONE)
                return true;
        } else if ($user->role_id == UserRole::SUPER_ADMINISTRATOR
            && ($model->role_id == UserRole::ADMINISTRATOR ||
                $model->role_id == UserRole::LENDER ||
                $model->role_id == UserRole::NONE))
            return true;
        return false;
    }
}
