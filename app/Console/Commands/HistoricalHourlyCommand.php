<?php

namespace App\Console\Commands;

use App\Services\HistoricalTimeFrameService;
use Illuminate\Console\Command;

class HistoricalHourlyCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'historical:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to get historical data hourly';

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
        $this->historicalTimeFrameService->updateHourlyData();
    }
}
