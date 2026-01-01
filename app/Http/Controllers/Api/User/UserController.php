<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;

class UserController extends BaseApiController
{
   /**
     * @OA\Put(
     *   path="/api/profile",
     *   tags={"User"},
     *   summary="Update user profile",
     *   security={{"sanctum":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", example="John Doe")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Profile updated successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Profile updated successfully")
     *     )
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validation error"
     *   )
     * )
     */

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->update($data);

        return $this->ok(null, 'Profile updated successfully');
    }

}
