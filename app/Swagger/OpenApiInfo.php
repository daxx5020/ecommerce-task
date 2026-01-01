<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Ecommerce API Documentation",
 *     description="API documentation for the Ecommerce application with authentication and role-based access control",
 *     @OA\Contact(
 *         email="support@ecommerce.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Enter token in format: Bearer <token>"
 * )
 */
class OpenApiInfo
{
    // This class is used only for OpenAPI annotations
}
