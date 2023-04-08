<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Author;

class AuthorTransformer extends TransformerAbstract
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
    public function transform(Author $author)
    {
        return [
            'identificador' => (int) $author->id,
            'nombre'=> (string) $author->name,
            'correo' => (string) $author->email,
            'es_verificado' => (int) $author->verified,
            'fecha_creacion' => (string) $author->created_at,
            'fecha_actualizacion' => (string) $author->updated_at,

            'links'=>[
                [
                    'rel' => 'self',
                    'href' => route('authors.show', $author->id),
                ],
                [
                    'rel' => 'user',
                    'href' => route('users.show', $author->id),
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
