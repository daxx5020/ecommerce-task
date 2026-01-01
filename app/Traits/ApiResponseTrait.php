<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    /**
     * Success response (200)
     */
    protected function ok(
        mixed $data = null,
        string $message = 'Success',
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    /**
     * Resource created (201)
     */
    protected function created(
        mixed $data = null,
        string $message = 'Resource created successfully'
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], Response::HTTP_CREATED);
    }

    /**
     * Error response (custom)
     */
    protected function error(
        string $message = 'Something went wrong',
        int $statusCode = Response::HTTP_BAD_REQUEST,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $statusCode);
    }

    /**
     * Unauthorized (401)
     */
    protected function unauthorized(
        string $message = 'Unauthorized access'
    ): JsonResponse {
        return $this->error(
            $message,
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Forbidden (403)
     */
    protected function forbidden(
        string $message = 'Forbidden access'
    ): JsonResponse {
        return $this->error(
            $message,
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * Validation error (422)
     */
    protected function validationError(
        mixed $errors,
        string $message = 'Validation failed'
    ): JsonResponse {
        return $this->error(
            $message,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $errors
        );
    }

    /**
     * Not found (404)
     */
    protected function notFound(
        string $message = 'Resource not found'
    ): JsonResponse {
        return $this->error(
            $message,
            Response::HTTP_NOT_FOUND
        );
    }
}
