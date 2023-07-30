<?php

namespace App\Exceptions;

use App\Traits\ResponseWrapper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseWrapper;

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

    public function render($request, Throwable $e)
    {
        // For 422 Response (Validation Error)
        if ($e instanceof ValidationException && $request->wantsJson()) {
            return $this->responseInvalidPayload($e->errors(), $e->getMessage());
        }

        // For 404 Response
        if (($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) && $request->wantsJson()) {
            return $this->responseNotFound();
        }

        // For 401 Response
        if ($e instanceof AuthenticationException && $request->wantsJson()) {
            return $this->responseUnauthenticated();
        }

        /*
            skip Validation, ModelNotFoundException and Auth Exception
            only check for other errors
            to remove try/catch from controllers
            for generic errors
        */
        if (
            !($e instanceof ModelNotFoundException) &&
            !($e instanceof ValidationException) &&
            !($e instanceof AuthenticationException) &&
            $request->wantsJson()
        ) {

            $response = [
                'data' => [],
                'message' => "Something went wrong",
                'success' => false,
            ];

            return response()->json($response, 500);
        }

        return parent::render($request, $e);
    }
}
