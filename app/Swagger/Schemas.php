<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"name", "email", "password", "password_confirmation"},
 *     @OA\Property(property="name", type="string", example="John Doe", description="User's full name"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
 *     @OA\Property(property="password", type="string", format="password", example="password123", description="Password (minimum 6 characters)"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="password123", description="Password confirmation")
 * )
 *
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
 *     @OA\Property(property="password", type="string", format="password", example="password123", description="User's password")
 * )
 *
 * @OA\Schema(
 *     schema="Role",
 *     @OA\Property(property="id", type="integer", example=1, description="Role ID"),
 *     @OA\Property(property="name", type="string", example="user", description="Role name"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2026-01-01T10:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2026-01-01T10:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(property="id", type="integer", example=1, description="User ID"),
 *     @OA\Property(property="name", type="string", example="John Doe", description="User's full name"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email address"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
 *     @OA\Property(property="status", type="boolean", example=true, description="Account status (active/inactive)"),
 *     @OA\Property(property="last_login", type="string", format="date-time", nullable=true, example="2026-01-01T10:00:00.000000Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2026-01-01T10:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2026-01-01T10:00:00.000000Z"),
 *     @OA\Property(
 *         property="roles",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Role"),
 *         description="User's assigned roles"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="AuthResponse",
 *     @OA\Property(property="success", type="boolean", example=true, description="Response status"),
 *     @OA\Property(property="message", type="string", example="Login successful", description="Response message"),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="token", type="string", example="1|abcdefghijklmnopqrstuvwxyz1234567890", description="API authentication token"),
 *         @OA\Property(property="user", ref="#/components/schemas/User", description="Authenticated user details")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ValidationError",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Validation failed"),
 *     @OA\Property(
 *         property="errors",
 *         type="object",
 *         @OA\Property(
 *             property="email",
 *             type="array",
 *             @OA\Items(type="string", example="The email field is required.")
 *         ),
 *         @OA\Property(
 *             property="password",
 *             type="array",
 *             @OA\Items(type="string", example="The password field is required.")
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="An error occurred"),
 *     @OA\Property(property="errors", type="object", nullable=true)
 * )
 */
class Schemas
{
    // This class is used only for OpenAPI schema annotations
}
