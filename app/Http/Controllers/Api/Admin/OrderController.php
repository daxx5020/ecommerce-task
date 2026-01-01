<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Api\BaseApiController;

class OrderController extends BaseApiController
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/admin/orders",
     *     tags={"Admin - Orders"},
     *     summary="List orders with filters",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="status", in="query", example="pending"),
     *     @OA\Parameter(name="from_date", in="query", example="2026-01-01"),
     *     @OA\Parameter(name="to_date", in="query", example="2026-01-31"),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request)
    {
        $orders = $this->orderService->filterOrders($request->all());

        return $this->ok([
            'orders' => $orders,
        ]);
    }


    /**
     * @OA\Patch(
     *     path="/api/admin/orders/{id}/status",
     *     tags={"Admin - Orders"},
     *     summary="Update order status",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="confirmed",
     *                 description="pending | confirmed | shipped | cancelled"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Order status updated"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = $this->orderService->updateOrderStatus($id, $request->status);

        return $this->ok([
            'order_id' => $order->id,
            'status'   => $order->status,
        ], 'Order status updated successfully');
    }



}
