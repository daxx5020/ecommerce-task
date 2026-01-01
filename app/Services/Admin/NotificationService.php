<?php

namespace App\Services\Admin;

use App\Jobs\SendBulkNotificationJob;

class NotificationService
{
    public function sendBulk(string $title, string $message): void
    {
        dispatch(new SendBulkNotificationJob($title, $message));
    }
}
