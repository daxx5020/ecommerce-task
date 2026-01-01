<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function updateLastLogin(User $user): void
    {
        $user->update(['last_login_at' => now()]);
    }

    /**
     * Admin: Get users with filters
     */
    public function getUsers(array $filters)
    {
        return User::query()
            ->with('roles')
            ->when($filters['status'] ?? null, function (Builder $q, $status) {
                $q->where('status', $status);
            })
            ->when($filters['search'] ?? null, function (Builder $q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->when($filters['from_date'] ?? null, fn ($q, $date) =>
                $q->whereDate('created_at', '>=', $date)
            )
            ->when($filters['to_date'] ?? null, fn ($q, $date) =>
                $q->whereDate('created_at', '<=', $date)
            )
            ->when($filters['role'] ?? null, function ($q, $role) {
                $q->whereHas('roles', fn ($r) => $r->where('name', $role));
            })
            ->when($filters['last_login_from'] ?? null, fn ($q, $date) =>
                $q->whereDate('last_login_at', '>=', $date)
            )
            ->orderBy(
                $filters['sort_by'] ?? 'created_at',
                $filters['sort_order'] ?? 'desc'
            );
    }

    public function summaryCounts($query = null): array
    {
        // If no query provided, use all users
        if (!$query) {
            $query = User::query();
        }

        return [
            'total_users'  => (clone $query)->count(),
            'active_users' => (clone $query)->where('status', true)->count(),
        ];
    }

    public function findById(int $id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function updateStatus(int $id, bool $status)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $status]);

        return $user->load('roles');
    }


}
