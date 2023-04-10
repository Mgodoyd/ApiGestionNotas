<?php

namespace App\Policies;

use App\Models\Notes;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotesPolicy
{
    public function view(User $user, Notes $notes): bool  // $user es el usuario autenticado, $notes es la nota que se está intentando ver
    {
         // Si el usuario es owner o autor, puede ver la nota
    if ($user->rol_id == 1 || $user->rol_id == 2) {
        
        return true;
    }
     // Si el usuario es escritor, solo puede ver y actualizar sus propias notas
     elseif ($user->rol_id == 2) {
        return $user->id === $notes->user_id;
    }
    // Si el usuario es lector, solo puede ver notas
    elseif ($user->rol_id == 4) {
        return true;
    }
    // Si el usuario no tiene un rol válido, no tiene acceso
    else {
        return false;
    }
    }
    public function update(User $user, Notes $notes): bool
    {
          // Si el usuario es owner o autor, puede ver la nota
          if ($user->rol_id == 1 || $user->rol_id == 2) {
            return true;
        }
         // Si el usuario es escritor, solo puede ver y actualizar sus propias notas
         elseif ($user->rol_id == 2) {
            return $user->id === $notes->user_id;
        }
        // Si el usuario es lector, solo puede ver notas
        elseif ($user->rol_id == 4) {
            return true;
        }
        // Si el usuario no tiene un rol válido, no tiene acceso
        else {
            return false;
        }
    }
    public function delete(User $user, Notes $notes): bool
    {
       // Si el usuario es owner o autor, puede ver la nota
       if ($user->rol_id == 1 || $user->rol_id == 2) {
        return true;
    }
     // Si el usuario es escritor, solo puede ver y actualizar sus propias notas
     elseif ($user->rol_id == 2) {
        return $user->id === $notes->user_id;
    }
    // Si el usuario es lector, solo puede ver notas
    elseif ($user->rol_id == 4) {
        return true;
    }
    // Si el usuario no tiene un rol válido, no tiene acceso
    else {
        return false;
    }
    }
}
