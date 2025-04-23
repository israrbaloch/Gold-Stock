<?php

namespace App\Services;

use App\DTO\CurrencyDTO;
use App\Models\HTGold15M;
use App\Models\HTGold1D;
use App\Models\HTGold1H;
use App\Models\HTGold1M;
use App\Models\HTGold5M;
use App\Models\HTPalladium15M;
use App\Models\HTPalladium1D;
use App\Models\HTPalladium1H;
use App\Models\HTPalladium1M;
use App\Models\HTPalladium5M;
use App\Models\HTPlatinum15M;
use App\Models\HTPlatinum1D;
use App\Models\HTPlatinum1H;
use App\Models\HTPlatinum1M;
use App\Models\HTPlatinum5M;
use App\Models\HTSilver15M;
use App\Models\HTSilver1D;
use App\Models\HTSilver1H;
use App\Models\HTSilver1M;
use App\Models\HTSilver5M;
use Cache;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use DB;
use Http;
use Log;

class HistoricalTimeFrameService {

    private  $currencySymbols = ["XAU/USD", "XAG/USD", "XPT/USD", "XPD/USD"];

    /**
     * Get the current metal price
     *
     * @param string $metal
     * @return CurrencyDTO
     */
    public function getCurrentMetal($metal) {
        switch ($metal) {
            case 'gold':
                return Cache::get('exchange_gold');
            case 'silver':
                return Cache::get('exchange_silver');
            case 'platinum':
                return Cache::get('exchange_platinum');
            case 'palladium':
                return Cache::get('exchange_palladium');
        }

        throw new \Exception("Metal not found: $metal");
    }

    public function updateDailyData() {
        $this->processTimeFrame(HTGold1D::class, HTSilver1D::class, HTPlatinum1D::class, HTPalladium1D::class, '-3 years');
    }

    public function updateHourlyData() {
        $this->processIntraDayTimeFrame('1h', HTGold1H::class, HTSilver1H::class, HTPlatinum1H::class, HTPalladium1H::class, 'P90D', '-1 year', '+90 days');
    }

    public function updateFifteenMinuteData() {
        $this->processIntraDayTimeFrame('15m', HTGold15M::class, HTSilver15M::class, HTPlatinum15M::class, HTPalladium15M::class, 'P30D', '-90 days', '+30 days');
    }

    public function updateFiveMinuteData() {
        $this->processIntraDayTimeFrame('5m', HTGold5M::class, HTSilver5M::class, HTPlatinum5M::class, HTPalladium5M::class, 'P10D', '-90 days', '+10 days');
    }

    public function updateOneMinuteData() {
        $this->processIntraDayTimeFrame('1m', HTGold1M::class, HTSilver1M::class, HTPlatinum1M::class, HTPalladium1M::class, 'P2D', '-90 days', '+2 days');
    }

    private function processTimeFrame($modelGold, $modelSilver, $modelPlatinum, $modelPalladium, $intervalFrom) {
        foreach ($this->currencySymbols as $code) {
            $to = date('Y-m-d');
            $from = date('Y-m-d', strtotime($intervalFrom, strtotime($to)));
            $url = "https://currencydatafeed.com/api/timeframe.php?token=" . config('services.datafeed.token') . "&currency=$code&from=$from&to=$to";

            $response = Http::get($url);
            $results = $response->json();
            $status = $results['status'];

            if (!$status) {
                Log::critical("Failed to fetch data from currencydatafeed.com/api/timeframe.php, with $code from $from to $to");
                continue;
            }

            $dataChunks = array_chunk($results['currency']['data'], 100); // Process data in chunks
            foreach ($dataChunks as $chunk) {
                $this->insertData($chunk, $code, $modelGold, $modelSilver, $modelPlatinum, $modelPalladium);
                gc_collect_cycles(); // Force garbage collection
            }
        }
    }

    private function processIntraDayTimeFrame($timeFrame, $modelGold, $modelSilver, $modelPlatinum, $modelPalladium, $intervalSpec, $intervalFrom, $intervalTime) {

        foreach ($this->currencySymbols as $code) {
            $end = Carbon::now('Europe/Helsinki')->setSeconds(0);

            $last = null;
            switch ($code) {
                case "XAU/USD":
                    $last = $modelGold::orderBy('timestamp_id', 'desc')->first();
                    break;
                case "XAG/USD":
                    $last = $modelSilver::orderBy('timestamp_id', 'desc')->first();
                    break;
                case "XPT/USD":
                    $last = $modelPlatinum::orderBy('timestamp_id', 'desc')->first();
                    break;
                case "XPD/USD":
                    $last = $modelPalladium::orderBy('timestamp_id', 'desc')->first();
                    break;
            }
            if (!$last) {
                $start = Carbon::now('Europe/Helsinki')->modify($intervalFrom)->setSeconds(0);
            } else {
                $start = Carbon::createFromTimestamp($last->timestamp_id, 'Europe/Helsinki');
            }
            $diff = $start->diff($end);

            $interval = new CarbonInterval($intervalSpec);
            // if the difference between start and end is less than the interval, set the difference as the interval
            if ($interval->gt($diff)) {
                $intervalTime = $diff->format('%R%y years %m months %d days %h hours %i minutes');
            }

            $dateRange = new CarbonPeriod($start, $interval, $end);
            $dateRange->setTimezone('Europe/Helsinki');

            foreach ($dateRange as $date) {
                $from = $date;
                $to = Carbon::parse($from)->add($intervalTime);

                $from = $from->format('Y-m-d H:i:s');
                $to = $to->format('Y-m-d H:i:s');

                $url = "https://currencydatafeed.com/api/intraday$timeFrame.php?token=" . config('services.datafeed.token') . "&currency=$code&from=$from&to=$to";

                $response = Http::get($url);
                $results = $response->json();
                $status = $results['status'];

                if (!$status) {
                    Log::critical("Failed to fetch data from currencydatafeed.com/api/intraday$timeFrame.php, with $code from $from to $to");
                    Log::critical($results['error']);
                    continue;
                }

                $dataChunks = array_chunk($results['currency']['data'], 100); // Process data in chunks
                foreach ($dataChunks as $chunk) {
                    $this->insertData($chunk, $code, $modelGold, $modelSilver, $modelPlatinum, $modelPalladium);
                    gc_collect_cycles(); // Force garbage collection
                }
            }
        }
    }

    private function insertData($dataChunk, $code, $modelGold, $modelSilver, $modelPlatinum, $modelPalladium) {
        $insertData = [];
        foreach ($dataChunk as $data) {
            $date = Carbon::parse($data['date'], 'Europe/Helsinki');
            $day = $date->dayOfWeek;

            $insertData[] = [
                'timestamp_id' => $date->timestamp,
                'open' => $data['open'],
                'high' => $data['high'],
                'low' => $data['low'],
                'close' => $data['close'],
                'market_open' => $day != 6 && $day != 0,
            ];
        }

        switch ($code) {
            case "XAU/USD":
                DB::table((new $modelGold)->getTable())->insertOrIgnore($insertData);
                break;
            case "XAG/USD":
                DB::table((new $modelSilver)->getTable())->insertOrIgnore($insertData);
                break;
            case "XPT/USD":
                DB::table((new $modelPlatinum)->getTable())->insertOrIgnore($insertData);
                break;
            case "XPD/USD":
                DB::table((new $modelPalladium)->getTable())->insertOrIgnore($insertData);
                break;
            default:
                Log::critical("Currency not found: $code");
                break;
        }
    }
}
