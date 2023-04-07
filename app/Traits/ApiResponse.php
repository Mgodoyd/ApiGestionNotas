<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
trait ApiResponse
{
    public function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message,$code){
        return response()->json(['Error' => $message,'code' => $code], $code);
    }

    protected function showAll($collection, $code = 200){
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $instance, $code = 200){
        return $this->successResponse(['data' => $instance], $code);
    }

}