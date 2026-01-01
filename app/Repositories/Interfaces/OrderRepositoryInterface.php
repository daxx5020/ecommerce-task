<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function createOrder(int $userId): Order;

    public function addItem(array $data): void;

    public function updateTotal(Order $order, float $total): void;

    public function listAll(): Collection;
}
