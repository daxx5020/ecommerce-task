<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Admin\UserListResource;

class UserManagementController extends BaseApiController
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/admin/users",
     *     tags={"Admin - Users"},
     *     summary="List users (Admin only)",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="search", in="query", example="john"),
     *     @OA\Parameter(name="status", in="query", example="1"),
     *     @OA\Parameter(name="from_date", in="query", example="2026-01-01"),
     *     @OA\Parameter(name="to_date", in="query", example="2026-01-31"),
     *     @OA\Parameter(name="per_page", in="query", example=10),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request)
    {
        $result = $this->userService->listUsers($request->all());

        return $this->ok([
            'users'   => UserListResource::collection($result['users']),
            'summary' => $result['summary'],
            'meta'    => [
                'current_page' => $result['users']->currentPage(),
                'total_pages'  => $result['users']->lastPage(),
                'total'        => $result['users']->total(),
            ],
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/users/{id}",
     *     tags={"Admin - Users"},
     *     summary="View single user (Admin only)",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer", example=7)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */


    public function show(int $id)
    {
        $user = $this->userService->getUserById($id);

        return $this->ok([
            'user' => new UserListResource($user),
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/api/admin/users/{id}/status",
     *     tags={"Admin - Users"},
     *     summary="Enable or disable a user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer", example=7)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User status updated successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */


    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $user = $this->userService->updateUserStatus($id, $request->status);

        return $this->ok([
            'user' => new UserListResource($user),
        ], 'User status updated successfully');
    }

}
