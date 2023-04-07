<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class Handler extends ExceptionHandler
{

    use ApiResponse;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];
    
     public function render($request, Throwable $exception){
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if($exception instanceof ModelNotFoundException){
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse('No se encontro ninguna instancia de'.'  '.$modelo.'  '.'con el id especificado', 404);
        }
        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request, $exception);
        }
        if($exception instanceof AuthenticationException){
            return $this->errorResponse('No posee permisos para ejecutar esta accion', 403);
        }
        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse('No se encontro la URL especificada', 404);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('El metodo especificado en la peticion no es valido', 405);
        }
        if($exception instanceof HttpException){  //para errores de tipo 404, 405, 500, etc se implementa esta condicion si no se implementan las ultimas 2 condiciones de arriba
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        if($exception instanceof QueryException){ 
            $codigo = $exception->errorInfo[1];
          // dd($exception);
            if($codigo == 547){
                return $this->errorResponse('No se puede eliminar por que el recurso esta relacionado con alguna nota', 409);
            }
        }
        if(config('app.debug')){   //si estamos en modo debug, se muestra el error
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Falla inesperada. Intente luego', 500);
;
     }

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    /*public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }*/

    protected function unauthenticated($request, AuthenticationException $exception){
        return $this->errorResponse('No autenticado', 401);
    }
    protected function convertValidationExceptionToResponse( $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
       
            return $this->errorResponse($errors, 422);
       
        
    }
}