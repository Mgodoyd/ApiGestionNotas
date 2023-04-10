<?php

namespace App\Transformers;

use App\Models\reader;
use League\Fractal\TransformerAbstract;

class ReaderTransformer extends TransformerAbstract
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
    public function transform(reader $reader) //recibe un objeto de tipo reader
    {
        return [
            'identificador' => (int) $reader->id,
            'nombre'=> (string) $reader->name,
            'correo' => (string) $reader->email,
            'es_verificado' => (int) $reader->verified,
            'fecha_creacion' => (string) $reader->created_at,
            'fecha_actualizacion' => (string) $reader->updated_at,

                'links' => [
                    
                        [
                            'rel' => 'self',
                            'href' => route('readers.show', $reader->id),
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
