<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\HistoricalTimeFrameService;

class HistoricalTimeFrameSeeder extends Seeder {


    protected $historicalTimeFrameService;

    public function __construct(HistoricalTimeFrameService $historicalTimeFrameService) {
        $this->historicalTimeFrameService = $historicalTimeFrameService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->historicalTimeFrameService->updateDailyData();
        $this->historicalTimeFrameService->updateHourlyData();
        $this->historicalTimeFrameService->updateFifteenMinuteData();
        $this->historicalTimeFrameService->updateFiveMinuteData();
        $this->historicalTimeFrameService->updateOneMinuteData();
    }
}
