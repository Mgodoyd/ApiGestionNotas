<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
   public function transform(User $user) //recibe un objeto de tipo user
    {
        return [
            'identificador' => (int) $user->id,
            'nombre'=> (string) $user->name,
            'correo' => (string) $user->email,
            'es_verificado' => (int) $user->is_verificado,
             'rol' => (string) $user->rol_id,
             'token' => (string) $user->verification_token,
            'fecha_creacion' => (string) $user->created_at,
            'fecha_actualizacion' => (string) $user->updated_at,
             
             'links' => [
                 
                    [
                        'rel' => 'self',
                        'href' => route('users.show', $user->id),
                    ],
                
            ]

        ];
    }

    public static function originalAttribute($index){//recibe el nombre de la columna de la base de datos
        $attributes = [
            'identificador' => 'id',
            'nombre'=> 'name',
            'correo' => 'email',
            'es_verificado' => 'is_verificado',
            'fecha_creacion' => 'created_at',
            'fecha_actualizacion' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
   
     public static function transformedAttribute($index){

        $attributes = [
            'id' => 'identificador',
            'name'=> 'nombre',
            'email' => 'correo',
            'is_verificado' => 'es_verificado',
            'created_at' => 'fecha_creacion',
            'updated_at' => 'fecha_actualizacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
     
}
