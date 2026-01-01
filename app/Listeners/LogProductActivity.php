<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ProductChanged;
use App\Models\ProductActivityLog;

class LogProductActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductChanged $event): void
    {
        ProductActivityLog::create([
            'product_id' => $event->productId,
            'action'     => $event->action,
            'old_data'   => $event->oldData,
            'new_data'   => $event->newData,
        ]);
    }
}
