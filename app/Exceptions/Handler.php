<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Validation\ValidationException;


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

        if($exception instanceof ValidationException){        //para errores de validacion
            return $this->convertValidationExceptionToResponse($exception, $request);
        } 

        if ($exception instanceof AuthorizationException) { //para errores de autorizacion
            return response()->json(['error' => 'No autorizado'], 403);
        }
        
        if($exception instanceof ModelNotFoundException){ //para errores de modelo
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse('No se encontro ninguna instancia de'.'  '.$modelo.'  '.'con el id especificado', 404);
        }
        if($exception instanceof AuthenticationException){ //para errores de autenticacion
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthenticationException && $request->expectsJson()) { //para errores de autenticacion
            return response()->json(['error' => 'No autenticado'], 401);
        }
        
        if($exception instanceof NotFoundHttpException){ //para errores de URL
            return $this->errorResponse('No se encontro la URL especificada', 404);
        }

        if($exception instanceof MethodNotAllowedHttpException){ //para errores de metodo no permitido
            return $this->errorResponse('El metodo especificado en la peticion no es valido', 405);
        }

        if($exception instanceof HttpException){  //para errores de tipo 404, 405, 500, etc se implementa esta condicion si no se implementan las ultimas 2 condiciones de arriba
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if($exception instanceof QueryException){ //para errores de base de datos
            $codigo = $exception->errorInfo[1];
          // dd($exception);
            if($codigo == 547){
                return $this->errorResponse('No se puede eliminar por que el recurso esta relacionado con alguna nota', 409);
            }
        }

        if($exception instanceof TokenMismatchException){ //para errores de token
            return redirect()->back()->withInput($request->input());
        }
        if(config('app.debug')){   //si estamos en modo debug, se muestra el error
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Falla inesperada. Intente luego', 500);

        
;
     }

// ...


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
    
    protected function unauthenticated($request, AuthenticationException $exception){ //para errores de autenticacion
        if($this->isFronted($request)){
            return redirect()->guest('login');
        }

        return $this->errorResponse('No autenticado', 403);
    }
    protected function convertValidationExceptionToResponse( $e, $request)  //para errores de validacion
    {
        $errors = $e->validator->errors()->getMessages();
        if($this->isFronted($request)){
              return $request->ajax() ? response()->json($errors,422) : redirect()
                   ->back()
                   ->withInput($request->input())
                   ->withErrors($errors);
                }
            return $this->errorResponse($errors, 422);
    }

    private function isFronted($request){   //se utiliza para determinar si una solicitud HTTP está dirigida a la aplicación web o si es una solicitud API
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}