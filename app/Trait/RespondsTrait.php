<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


trait RespondsTrait
{/**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function success($data = null, $message = 'Success', $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param int $status
     * @param mixed $errors
     * @return JsonResponse
     */
    public function error($message = 'Error', $errors = null, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {

        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }


    /**
     * Not found response
     *
     * @param string $message
     * @return JsonResponse
     */
    public function notFound($message = 'Not Found'): JsonResponse
    {
        return $this->error($message, null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Internal server error response
     *
     * @param string $message
     * @return JsonResponse
     */
    public function internalServerError($message = 'Internal Server Error'): JsonResponse
    {
        return $this->error($message, null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
