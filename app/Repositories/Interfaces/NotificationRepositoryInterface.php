<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface NotificationRepositoryInterface
{
    public function create(array $data): void;

    public function bulkCreate(array $rows): void;

    public function getUsersForNotification(): Collection;
}
