<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{
    public function topUsers(array $filters): Collection
    {
        $query = DB::table('users')
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->where('users.status', true)
            ->when($filters['from'] ?? null, fn ($q, $d) =>
                $q->whereDate('orders.created_at', '>=', $d)
            )
            ->when($filters['to'] ?? null, fn ($q, $d) =>
                $q->whereDate('orders.created_at', '<=', $d)
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.last_login_at')
            ->selectRaw('
                users.id,
                users.name,
                users.email,
                COUNT(orders.id) as total_orders,
                SUM(orders.total_amount) as total_spent,
                AVG(orders.total_amount) as avg_order_value,
                MAX(orders.created_at) as last_order_date,
                SUM(CASE WHEN orders.status = "cancelled" THEN 1 ELSE 0 END) as cancelled_orders,
                DATEDIFF(NOW(), users.last_login_at) as days_since_last_login_at
            ')
            ->orderByDesc('total_orders')
            ->limit(5);

        return collect($query->get());
    }
}
