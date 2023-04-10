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
{  
    dd($authenticatedUser->rol_id, $user->rol_id);  
    return $authenticatedUser->rol_id === $user->rol_id; 
}

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->rol_id === $user->rol_id;
 
   // return $authenticatedUser->rol_id === $user->rol_id;


    }

}
