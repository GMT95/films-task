<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait ResponseWrapper
{
    public function responseOk($data, string $message = 'API Successful', bool $success = true): JsonResponse
    {
        $response = compact('data', 'message', 'success');

        return response()->json($response);
    }

    public function responseCreated($data, string $message = 'API Successful', bool $success = true): JsonResponse
    {
        $response = compact('data', 'message', 'success');

        return response()->json($response, 201);
    }

    public function responseException(string $message = 'Something Went Wrong', bool $success = false): JsonResponse
    {
        $response = [
            'data' => [],
            'message' => $message,
            'success' => $success,
        ];

        return response()->json($response, 500);
    }

    public function responseNotFound(string $message = 'Record Not Found', bool $success = false): JsonResponse
    {
        $response = [
            'data' => [],
            'message' => $message,
            'success' => $success,
        ];

        return response()->json($response, 404);
    }

    public function responseInvalidPayload($errors, $message, $success = false): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => ['errors' => $errors],
            'success' => $success,
        ];

        return response()->json($response, 422);
    }

    public function responseUnauthenticated(string $message = 'You are unauthenticated', bool $success = false): JsonResponse
    {
        $response = [
            'data' => [],
            'message' => $message,
            'success' => $success,
        ];

        return response()->json($response, 401);
    }

}
