<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckAlertsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // You can add any additional properties or constructor parameters if needed.

    public function __construct()
    {
        // Constructor logic (if any)
    }

    public function handle()
    {
        // Call your artisan command 'alerts:check'
        \Artisan::call('alerts:check');
    }
}