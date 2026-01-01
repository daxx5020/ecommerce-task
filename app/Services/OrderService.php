<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository
    ) {}

    public function placeOrder(array $items, int $userId)
    {
        return DB::transaction(function () use ($items, $userId) {

            $order = $this->orderRepository->createOrder($userId);
            $total = 0;

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if ($product->quantity < $item['quantity']) {
                    throw new \Exception('Insufficient stock');
                }

                $price = $product->price - $product->discount;

                $this->orderRepository->addItem([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $price,
                ]);

                $product->decrement('quantity', $item['quantity']);

                if ($product->quantity === 0) {
                    $product->update(['in_stock' => false]);
                }

                $total += $price * $item['quantity'];
            }

            $this->orderRepository->updateTotal($order, $total);

            return $order;
        });
    }

    public function listOrders()
    {
        return $this->orderRepository->listAll();
    }

    public function updateOrderStatus(int $orderId, string $status)
    {
        $allowed = ['pending', 'confirmed', 'shipped', 'cancelled'];

        if (! in_array($status, $allowed)) {
            throw new \InvalidArgumentException('Invalid order status');
        }

        $order = $this->orderRepository->findById($orderId);

        return $this->orderRepository->updateStatus($order, $status);
    }

    public function filterOrders(array $filters)
    {
        return $this->orderRepository->filter($filters);
    }

    public function getUserOrders(int $userId)
    {
        return \App\Models\Order::with('items.product')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }


}
