<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
     public function update(User $authenticatedUser, User $user): bool
{        // Si el usuario es owner puede ver los usuarios
    return $user->id === $user->id;
}

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authenticatedUser, User $user): bool
    {
             // Si el usuario es owner puede ver los usuarios
             return $user->id === $user->id;

    }
}