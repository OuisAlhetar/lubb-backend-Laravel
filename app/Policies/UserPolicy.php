<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only 'Admin' or 'Super Admin' can view the user list
        return $user->hasRole(['Admin','Super Admin','Writer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Users can view their own profile, or Admins can view any profile
        return $user->id === $model->id || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only 'Admin' or 'Super Admin' can create new users
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Users can update their own profile, or Admins can update any profile
        return $user->id === $model->id || $user->hasRole(['Super Admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Only 'Super Admin' can delete users
        return $user->hasRole('Super Admin') && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Only 'Super Admin' can restore deleted users
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Only 'Super Admin' can permanently delete users
        return $user->hasRole('Super Admin') && $user->id !== $model->id;
    }
}
