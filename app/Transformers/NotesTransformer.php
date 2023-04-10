<?php

namespace App\Transformers;

use App\Models\Notes;
use League\Fractal\TransformerAbstract;

class NotesTransformer extends TransformerAbstract
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
    public function transform(Notes $note) //recibe un objeto de tipo notes
    {
        return [
            'identificador' => (int) $note->id,
            'titulo'=> (string) $note->title,
            'descripcion' => (string) $note->content,
            'fecha_creacion' => (string) $note->created_at,
            'fecha_actualizacion' => (string) $note->updated_at,
            'Usuario' => (int) $note->user_id,
            'Estatus' => (int) $note->states_id,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('notes.show', $note->id),
                ],
                [
                    'rel' => 'notes.states',
                    'href' => route('notes.states.index', $note->states_id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index){ //recibe el nombre de la columna de la base de datos
        $attributes = [
            'identificador' => 'id',
            'titulo'=> 'title',
            'descripcion' => 'content',
            'fecha_creacion' => 'created_at',
            'fecha_actualizacion' => 'updated_at',
            'Usuario' => 'user_id',
            'Estatus' => 'states_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index){ //recibe el nombre de la columna de la base de datos
        $attributes = [
            'id' => 'identificador',
            'title'=> 'titulo',
            'content' => 'descripcion',
            'created_at' => 'fecha_creacion',
            'updated_at' => 'fecha_actualizacion',
            'user_id' => 'Usuario',
            'states_id' => 'Estatus',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
