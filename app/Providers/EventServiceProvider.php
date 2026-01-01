<?php

namespace App\Providers;

use App\Events\ProductChanged;
use App\Listeners\LogProductActivity;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register event listeners
        \Illuminate\Support\Facades\Event::listen(
            ProductChanged::class,
            LogProductActivity::class
        );
    }
}
