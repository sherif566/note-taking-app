<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait RespondsWithHttpStatus
{
    protected function success($data, $message = '', $status = JsonResponse::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function error($message, $data = [], $status = JsonResponse::HTTP_NOT_FOUND)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
