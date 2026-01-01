<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(int $userId): Order
    {
        return Order::create([
            'user_id' => $userId,
            'total_amount' => 0,
            'status' => 'pending',
        ]);
    }

    public function addItem(array $data): void
    {
        OrderItem::create($data);
    }

    public function updateTotal(Order $order, float $total): void
    {
        $order->update(['total_amount' => $total]);
    }

    public function listAll(): Collection
    {
        return Order::with('user')
            ->latest()
            ->get(['id','user_id','total_amount','status','created_at']);
    }

    public function findById(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);
        return $order;
    }

    public function filter(array $filters)
    {
        return Order::query()
            ->when($filters['status'] ?? null, fn ($q, $status) =>
                $q->where('status', $status)
            )
            ->when($filters['from_date'] ?? null, fn ($q, $date) =>
                $q->whereDate('created_at', '>=', $date)
            )
            ->when($filters['to_date'] ?? null, fn ($q, $date) =>
                $q->whereDate('created_at', '<=', $date)
            )
            ->latest()
            ->get(['id','user_id','total_amount','status','created_at']);
    }

}
