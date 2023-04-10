<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\Cache;

trait ApiResponse
{
    public function successResponse($data, $code) //funcion para devolver respuesta exitosa
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message,$code){ //funcion para devolver respuesta de error
        return response()->json(['Error' => $message,'code' => $code], $code);
    }

    protected function showAll($collection, $code = 200){ //funcion para devolver respuesta de todos los datos

         if($collection->isEmpty()){
            return $this->successResponse(['data' => $collection],$code);
         }

        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);
        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200){ //para mostrar el modelo por individual
           
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance,$transformer);

        return $this->successResponse($instance, $code);
    }
   
    protected function filterData(Collection $collection, $transformer){ //para filtrar por campo elegido
       
       foreach(request()->query() as $query => $value){
            $attribute = $transformer::originalAttribute($query);

            if(isset($attribute, $value)){
                $collection = $collection->where($attribute, $value);}
       }
         return $collection;
    }
   protected function sortData(Collection $collection, $transformer ){   //para ordenar por campo elegido
        if(request()->has('sort_by')){
            $sort = $transformer::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy->{$sort};
        }
        return $collection;
   }
    protected function transformData($data, $transformer){ //para transformar los datos
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }

    protected function cacheResponse($data){ //para cachear los datos
        $url = request()->url();

        return Cache::remember($url,30/60,function() use($data){
            return $data;
        });
    }

}