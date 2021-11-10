<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof UnauthorizedHttpException) {
            return response()->json([
                'message' => 'unauthorized',
            ], 401);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => 'not_found',
            ], 404);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => 'invalid_data',
                'errors' => $e->errors()
            ], $e->status);
        }

        if ($e instanceof AccessDeniedHttpException) {
            $message = $e->getMessage();
            if (!strlen($message)) {
                $message = 'access_denied';
            }
            return response()->json([
                'message' => $message
            ], 403);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'message' => 'access_denied'
            ], 403);
        }

        if ($e instanceof QueryException) {
            return response()->json([
                'message' => 'bad_request'
            ], 400);
        }

        return parent::render($request, $e);
    }
}
