<?php

namespace App\Console\Commands;

use App\Services\HistoricalTimeFrameService;
use Illuminate\Console\Command;

class HistoricalFifteenCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historical:fifteen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to get historical data every fifteen minutes';

    private $historicalTimeFrameService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HistoricalTimeFrameService $historicalTimeFrameService) {
        parent::__construct();
        $this->historicalTimeFrameService = $historicalTimeFrameService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $this->historicalTimeFrameService->updateFifteenMinuteData();
    }
}
