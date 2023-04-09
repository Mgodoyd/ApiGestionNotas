<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authenticatedUser, User $user): bool
    {
       // return $authenticatedUser->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->rol_id === $user->id;
    }
    

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authenticatedUser, User $user): bool
    {
       // return $authenticatedUser->rol_id === $user->rol_id && $authenticatedUser->tokenCan()->client->personal_access_client;
 
    return $authenticatedUser->rol_id === $user->rol_id;


    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
