<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(
        mixed $data = null,
        ?string $message = null,
        int $status = 200,
        mixed $meta = null
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'meta' => $meta,
        ], $status);
    }

    public static function error(
        string $message,
        int $status = 400,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'data' => null,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
