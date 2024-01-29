<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Services\CreateUserService;
use App\Exceptions\AppError;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // Sobrescrevendo o método render (Polimorfismo)
    public function render($request, Throwable $error) {

        if($error instanceof ValidationException){
            return response()->json([
                'errors' => $error->validator->errors()
            ], 422);
        }

        if($error instanceof AppError) {
            return response()->json([
                'errors' => $error->getMessage()
            ], $error->getCode());
        }

        if($error instanceof AuthorizationException) {
            return response()->json([
                'errors' => 'Usuário não autorizado.'
            ], 403);
        }

        if($error instanceof NotFoundHttpException) {
            return response()->json([
                'errors' => 'Rota não encontrada'
            ], 404);
        }

        return response()->json([
            'message' => 'Internal Server Error'
        ], 500);
    }
}
