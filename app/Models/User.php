<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const VERIFICADO = '1';
    const NO_VERIFICADO = '0';

    protected $fillable = [  //campos que se pueden asignar de manera masiva
        'name',
        'email',
        'password',
        'rol_id',
       // 'is_verificado',

    ];

    protected $hidden = [
        'password',
        'verification_token',
        'is_verificado',
    ];

    // Verificación de usuario
    public function getRoles()
    {
        $roles = [];

        $rolesQuery = DB::table('roles')
                        ->where('email', '=', $this->correo, 'and', 'password', '=', $this->contraseña)
                        ->select('role');

        if ($rolesQuery->where('role', '=', 'admin')->count() > 0) {
            $roles[] = 'admin';
        }

        if ($rolesQuery->where('role', '=', 'autor')->count() > 0) {
            $roles[] = 'autor';
        }

        if ($rolesQuery->where('role', '=', 'lector')->count() > 0) {
            $roles[] = 'lector';
        }

        if ($rolesQuery->where('role', '=', 'escritor')->count() > 0) {
            $roles[] = 'escritor';
        }

        return $roles;
    }

    // Función para verificar el usuario
    public function isVerificado()
    {
        return $this->is_verificado === self::VERIFICADO;
    }

    // Validación de roles de usuario
    public function isAdmin()
   {
    return $this->rol === 'admin';
   }

    public function isAutor()
   {
    return $this->rol === 'autor';
   }

    public function isLector()
    {
      return $this->rol === 'lector';
    }

    public function isEscritor()
    {
       return $this->rol === 'escritor';
    }
   
    //generar token de verificación 
    public static function generateVerificationToken()
    {
        return Str::random(40);
    }

    public function rol()
{
    return $this->belongsTo(Rol::class, 'rol_id'); // "muchos a uno"
}
}
