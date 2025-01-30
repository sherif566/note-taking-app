<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait RespondsWithHttpStatus
{
    protected function success($data, $message = '', $status = JsonResponse::HTTP_OK): JsonResponse
    {
        if ($data instanceof \Illuminate\Http\Resources\Json\ResourceCollection) {
            $data = $data->response()->getData(true); // Convert resource collection to array
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function error($message, $data = [], $status = JsonResponse::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
