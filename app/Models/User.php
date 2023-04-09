<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const VERIFICADO = '1';
    const NO_VERIFICADO = '0';

   /* const USUARIO_ADMINISTRADOR = 1;
    const USUARIO_REGULAR = 'false';*/


    public $transformer = UserTransformer::class;

    protected $table = 'users'; //con esto le decimos que la tabla se llama users para iniciar sesion con el modelo user
    protected $fillable = [  //campos que se pueden asignar de manera masiva
        'name',
        'email',
        'password',
        'rol_id',
       // 'is_verificado',
       
       'verification_token',

    ];

    protected $hidden = [
        'password',
      //  'verification_token',
        'is_verificado',
        'pivot'
    ];

    //mutador para el campo name para que siempre se guarde en minusculas
    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtolower($valor);
    }

    //accessor para el campo name para que siempre se muestre en mayusculas
    public function getNameAttribute($valor)
    {
        return ucwords($valor);
    }

    //accesor para el campo email para que siempre se guarde en minusculas
    public function setEmailAttribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }

    // Verificación de usuario
   /* public function getRoles()
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
    }*/
    // Función para verificar el usuario
    public function isVerificado()
    {
        return $this->is_verificado === self::VERIFICADO;
    }
    /*public function esAdministrador()
    {
        return $this->id == User::USUARIO_ADMINISTRADOR;
    }*/
    //generar token de verificación 
    public static function generateVerificationToken()
    {
        return Str::random(40);
    }

    public function rol()
{
    return $this->belongsTo(Rol::class, 'rol_id'); // "muchos a uno"
}

public function roles()
{
    return $this->belongsToMany(Rol::class, 'rol_user'); //estoy accesando a la tabla rol_user que es la que relaciona los roles con los usuarios
} 

}
