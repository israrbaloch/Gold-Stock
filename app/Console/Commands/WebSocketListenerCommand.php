<?php

namespace App\Console\Commands;

use App\Services\HistoricalWebSocketService;
use Illuminate\Console\Command;

class WebSocketListenerCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historical:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $historicalWebSocketService;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HistoricalWebSocketService $historicalWebSocketService) {
        $this->historicalWebSocketService = $historicalWebSocketService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $this->historicalWebSocketService->run();
    }
}
