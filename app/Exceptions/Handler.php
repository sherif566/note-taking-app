<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            // Log exceptions here if needed
        });
    }

    /**
     * Handle validation errors globally.
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $exception->errors(),
        ], 422);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle Model Not Found Exceptions
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found',
                'message' => $exception->getMessage(),
            ], 404);
        }

        // Handle Not Found HTTP Exceptions
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Endpoint not found',
                'message' => 'The requested URL was not found on this server.',
            ], 404);
        }

        // Handle Method Not Allowed HTTP Exceptions
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => 'Method not allowed',
                'message' => 'The HTTP method used is not supported for this endpoint.',
            ], 405);
        }

        // Handle Authentication Exceptions
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Authentication required',
                'message' => $exception->getMessage(),
            ], 401);
        }

        // Handle Validation Exceptions (fallback if global handler is not applied)
        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $exception->errors(),
            ], 422);
        }

        // Handle any other exceptions (fallback)
        return parent::render($request, $exception);
    }
}
