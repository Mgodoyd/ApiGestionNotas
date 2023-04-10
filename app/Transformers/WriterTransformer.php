<?php

namespace App\Transformers;

use App\Models\writer;
use League\Fractal\TransformerAbstract;

class WriterTransformer extends TransformerAbstract
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
    public function transform(writer $writer) //recibe un objeto de tipo writer
    {
        return [
            'identificador' => (int) $writer->id,
            'nombre'=> (string) $writer->name,
            'correo' => (string) $writer->email,
            'es_verificado' => (int) $writer->verified,
            'fecha_creacion' => (string) $writer->created_at,
            'fecha_actualizacion' => (string) $writer->updated_at,

            'links'=>[
                [
                    'rel' => 'self',
                    'href' => route('writers.show', $writer->id),
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $writer->id),
                ],
            ],
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
