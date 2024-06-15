<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
    public function register(): void
    {
//        $this->reportable(function (Throwable $e) {
//            //
//        });

        $this->renderable(function (AuthorizationException $e, $request) {
            return response()->json([
                'message' => 'You are not authorized to access this resource',
            ], 403);
        });

        $this->renderable(function (NotFoundHttpException|ModelNotFoundException $e, $request) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        });

        $this->renderable(function (ThrottleRequestsException $e, $request) {
            return response()->json([
                'errors' => [
                    'message' => 'Too many requests.',
                ],
            ], 419);
        });
    }
}
