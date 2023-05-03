<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const VERIFICADO = '1';
    const NO_VERIFICADO = '0';

    public $transformer = UserTransformer::class;//transformador de la clase

    protected $table = 'users'; //con esto le decimos que la tabla se llama users para iniciar sesion con el modelo user
    protected $fillable = [  //campos que se pueden asignar de manera masiva
        'name',
        'email',
        'password',
        'rol_id',
        'is_verificado',
        'verification_token',
        'rol_id',
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

    // Función para verificar el usuario
    public function isVerificado()
    {
        return $this->is_verificado === self::VERIFICADO;
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

   public function roles()
   {
    return $this->belongsToMany(Rol::class, 'rol_user'); //estoy accesando a la tabla rol_user que es la que relaciona los roles con los usuarios
   } 
  
   public function notes()
{
    return $this->hasMany(Notes::class); 
}


}

