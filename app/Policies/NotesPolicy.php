<?php

namespace App\Policies;

use App\Models\Notes;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotesPolicy
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
    public function view(User $user, Notes $notes): bool
    {
         // Si el usuario es owner o autor, puede ver la nota
    if ($user->role == 'owner' || $user->role == 'autor') {
        return true;
    }
     // Si el usuario es escritor, solo puede ver y actualizar sus propias notas
     elseif ($user->role == 'escritor') {
        return $user->id === $notes->user_id;
    }
    // Si el usuario es lector, solo puede ver notas
    elseif ($user->role == 'lector') {
        return true;
    }
    // Si el usuario no tiene un rol válido, no tiene acceso
    else {
        return false;
    }
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
    public function update(User $user, Notes $notes): bool
    {
           // Si el usuario es owner o autor, puede actualizar la nota
    if ($user->role == 'owner' || $user->role == 'autor') {
        return true;
    }
    // Si el usuario es escritor, solo puede actualizar sus propias notas
    elseif ($user->role == 'escritor') {
        return $user->id === $notes->user_id;
    }
    // Si el usuario es lector, no puede actualizar notas
    elseif ($user->role == 'lector') {
        return false;
    }
    // Si el usuario no tiene un rol válido, no tiene acceso
    else {
        return false;
    }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Notes $notes): bool
    {
             // Si el usuario es owner o autor, puede borrar la nota
    if ($user->role == 'owner' || $user->role == 'autor') {
        return true;
    }
    // Si el usuario es escritor, solo puede borrar sus propias notas
    elseif ($user->role == 'escritor') {
        return $user->id === $notes->user_id;
    }
    // Si el usuario es lector, no puede borrar notas
    elseif ($user->role == 'lector') {
        return false;
    }
    // Si el usuario no tiene un rol válido, no tiene acceso
    else {
        return false;
    }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Notes $notes): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Notes $notes): bool
    {
   
    }
}
