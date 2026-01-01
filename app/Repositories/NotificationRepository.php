<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function create(array $data): void
    {
        Notification::create($data);
    }

    public function bulkCreate(array $rows): void
    {
        Notification::insert($rows);
    }

    public function getUsersForNotification(): Collection
    {
        return User::where('status', true)
            ->get(['id']);
    }
}
