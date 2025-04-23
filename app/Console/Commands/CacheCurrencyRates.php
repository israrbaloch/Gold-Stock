<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class CacheCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:currency-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and cache currency rates forever, overwriting each night';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currencies = [
            'XAU/USD','XAG/USD','XPT/USD', 'XPD/USD', 'USD/CAD', 'EUR/USD'
        ]; // Add your list of currency pairs here
        $dates = [
            'today' => Carbon::now()->toDateString(),
            'week' => Carbon::now()->subDays(7)->toDateString(),
            'month' => Carbon::now()->subDays(30)->toDateString(),
            'six_months' => Carbon::now()->subMonths(6)->toDateString(),
            'year' => Carbon::now()->subDays(360)->toDateString(),
        ];

        foreach ($currencies as $currency) {
            $data = [];
            foreach ($dates as $key => $date) {
                $rate = $this->fetchRate($currency, $date);
                $data[$key] = $rate;
            }
            Cache::forever($currency, $data);

            $this->info("Cached ". $currency ." - ". $data['today'] ." - ". $data['week'] ." - ". $data['month'] ." - ". $data['six_months'] ." - ". $data['year']);
        }

        return Command::SUCCESS;
    }

    /**
     * Fetch the historical price for a given currency and date.
     *
     * @param string $code
     * @param string $date
     * @return mixed
     */
    private function fetchRate($code, $date)
    {
        $from = Carbon::parse($date)->startOfDay()->toDateTimeString();
        $to = Carbon::parse($date)->addHours(2)->toDateTimeString();

        $url = "https://currencydatafeed.com/api/intraday1h.php?token=" . config('services.datafeed.token') . "&currency=" . $code . "&from=$from&to=$to";

        $response = Http::get($url);

        if ($response->successful()) {
            $results = $response->json();

            // dd($results);
            return $results['currency']['data'][0]['close'] ?? null;
        }

        return null;
    }
}
