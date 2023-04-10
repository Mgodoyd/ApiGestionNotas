<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    
    /**
     * Determine whether the user can update the model.
     */
    
     public function update(User $authenticatedUser, User $user): bool
{        // Si el usuario es owner o autor, puede ver la nota
    return $user->id === $user->id;
}

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authenticatedUser, User $user): bool
    {
             // Si el usuario es owner o autor, puede ver la nota
             return $user->id === $user->id;

}
}