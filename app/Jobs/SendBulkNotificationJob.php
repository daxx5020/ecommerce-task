<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class SendBulkNotificationJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 3;

    public function __construct(
        protected string $title,
        protected string $message
    ) {}

    public function handle(NotificationRepositoryInterface $repository): void
    {
        $users = $repository->getUsersForNotification();

        $rows = $users->map(fn ($user) => [
            'user_id'    => $user->id,
            'title'      => $this->title,
            'message'    => $this->message,
            'is_read'    => false,
            'created_at'=> now(),
            'updated_at'=> now(),
        ])->toArray();

        $repository->bulkCreate($rows);
    }
}
