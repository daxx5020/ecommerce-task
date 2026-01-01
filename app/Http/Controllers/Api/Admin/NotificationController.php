<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\NotificationService;
use App\Http\Controllers\Api\BaseApiController;

class NotificationController extends BaseApiController
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    /**
     * @OA\Post(
     *     path="/api/admin/notifications",
     *     tags={"Admin - Notifications"},
     *     summary="Send bulk notification",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","message"},
     *             @OA\Property(property="title", type="string", example="New Product"),
     *             @OA\Property(property="message", type="string", example="Check out our new arrivals")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Notification queued")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $this->notificationService->sendBulk(
            $data['title'],
            $data['message']
        );

        return $this->ok(
            null,
            'Notification queued successfully'
        );
    }
}
