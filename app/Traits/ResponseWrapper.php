<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

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

    public function responsePaginated(LengthAwarePaginator $paginatedData, string $keyName, string $message = 'List Data', bool $success = true): JsonResponse
    {
        $response = [
            'data' => [
                $keyName => $paginatedData->items(),
                'current_page' => $paginatedData->currentPage(),
                'total_pages' => $paginatedData->lastPage(),
                'total' => $paginatedData->total()
            ],
            'message' => $message,
            'success' => $success,
        ];

        return response()->json($response, 200);
    }

}
