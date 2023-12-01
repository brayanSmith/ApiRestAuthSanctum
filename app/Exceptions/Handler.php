<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e,$request) {
            //en caso que no encuentre el valor aparecera lo siguiente
            if($request->is('api/departaments/*')){
                return response()->json([
                    'status' => false,
                    'message' => 'The selected id is invalid'
                ],404);
            }
            if($request->is('api/employees/*')){
                return response()->json([
                    'status' => false,
                    'message' => 'The selected employee is invalid'
                ],404);
            }
        });
    }
}
