<?php

namespace App\Transformers;

use App\Models\States;
use League\Fractal\TransformerAbstract;

class StateTransformer extends TransformerAbstract
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
    public function transform(States $state)
    {
        return [
            'identificador' => (int) $state->id,
            'nombre'=> (string) $state->name_status,
            'fecha_creacion' => (string) $state->created_at,
            'fecha_actualizacion' => (string) $state->updated_at,

              'links'=> [

                [
                    'rel' => 'self',
                    'href' => route('states.show', $state->id),
                ],
              ]
        ];
    }

    public static function originalAttribute($index){
        $attributes = [
            'identificador' => 'id',
            'nombre'=> 'name_status',
            'fecha_creacion' => 'created_at',
            'fecha_actualizacion' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'name_status' => 'nombre',
            'created_at' => 'fecha_creacion',
            'updated_at' => 'fecha_actualizacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
