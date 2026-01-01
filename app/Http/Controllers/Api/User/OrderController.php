<?php

namespace App\Http\Controllers\Api\User;

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
     *     path="/api/my-orders",
     *     tags={"User - Orders"},
     *     summary="View own orders",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request)
    {
        $orders = $this->orderService->getUserOrders(
            $request->user()->id
        );

        return $this->ok([
            'orders' => $orders,
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/orders",
     *     tags={"User - Orders"},
     *     summary="Place an order",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"items"},
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     required={"product_id","quantity"},
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order placed successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        $order = $this->orderService->placeOrder(
            $data['items'],
            $request->user()->id
        );

        return $this->created([
            'order_id' => $order->id,
            'total'    => $order->total_amount,
        ], 'Order placed successfully');
    }
}
