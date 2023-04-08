<?php

namespace App\Transformers;

use App\Models\Rol;
use League\Fractal\TransformerAbstract;

class RolTransformer extends TransformerAbstract
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
    public function transform(Rol $rol)
    {
        return [
            'identificador' => (int) $rol->id,
            'nombre'=> (string) $rol->name_role,
            'fecha_creacion' => (string) $rol->created_at,
            'fecha_actualizacion' => (string) $rol->updated_at,

             'links' => [
                [
                    'rel' => 'self',
                    'href' => route('rols.show', $rol->id),
                ],
                [
                    'rel' => 'roles.users',
                    'href' => route('rols.users.index', $rol->id),
                ],

        ]
    ];
    }

    public static function originalAttribute($index){
        $attributes = [
            'identificador' => 'id',
            'nombre'=> 'name_role',
            'fecha_creacion' => 'created_at',
            'fecha_actualizacion' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'name_role'=> 'nombre',
            'created_at' => 'fecha_creacion',
            'updated_at' => 'fecha_actualizacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

}
