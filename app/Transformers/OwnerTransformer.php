<?php

namespace App\Transformers;

use App\Models\owner;
use League\Fractal\TransformerAbstract;

class OwnerTransformer extends TransformerAbstract
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
    public function transform(owner $owner)
    {
        return [
            'identificador' => (int) $owner->id,
            'nombre'=> (string) $owner->name,
            'correo' => (string) $owner->email,
            'es_verificado' => (int) $owner->verified,
            'fecha_creacion' => (string) $owner->created_at,
            'fecha_actualizacion' => (string) $owner->updated_at,

            'links'=>[
                [
                    'rel' => 'self',
                    'href' => route('owners.show', $owner->id),
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $owner->id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index){
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

    public static function transformedAttrigure($index){
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
