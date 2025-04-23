<?php

namespace App\Console\Commands;

use App\DTO\CurrencyDTO;
use App\Jobs\CheckAlertsJob;
use Http;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Log;
use PDOException;

class HistoricalPriceCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {

        $code_array = array("XAU/USD", "XAG/USD", "XPT/USD", "XPD/USD");

        $url = 'https://currencydatafeed.com/api/data.php?token=' . config('services.datafeed.token') . '&currency=' . join("+", $code_array);

        $response = Http::get($url);
        $results = $response->json();

        $status = $results['status'];

        if (config('app.env') == 'local') {
            Log::info($status == 1 ? "Success" : "Failed");
        }

        if (!$status) {
            Log::critical("Failed to fetch data from currencydatafeed.com, with " . join(",", $code_array));
            return;
        }

        $currencies = array_map(fn ($currency) => new CurrencyDTO($currency), $results['currency']);
        foreach ($currencies as $currency) {
            $table = "";

            switch ($currency->currency) {
                case 'XAU/USD':
                    $table = 'ic_historical_price_gold';
                    break;
                case 'XAG/USD':
                    $table = 'ic_historical_price_silver';
                    break;
                case 'XPT/USD':
                    $table = 'ic_historical_price_plat';
                    break;
                case 'XPD/USD':
                    $table = 'ic_historical_price_pall';
                    break;
                default:
                    Log::critical("Currency not found: " . $currency->currency);
                    continue 2;
            }


            try {
                $result = DB::table($table)->select('id')->where('value_date', $currency->date)->count();
                if ($result < 1) {
                    DB::table($table)->insert([
                        'current_value' => $currency->value,
                        'change_value' => $currency->change,
                        'change_percent' => $currency->change_percent,
                        'ask' => $currency->ask,
                        'bid' => $currency->bid,
                        'daily_lowest' => $currency->daily_lowest,
                        'daily_highest' => $currency->daily_highest,
                        'value_date' => $currency->date,
                        'current_type' => $currency->type,
                        'timestamp' => time()
                    ]);

                    // alerts:check artisan command
                    // try {
                    //     $this->call('alerts:check');
                    // } catch (\Throwable $th) {
                    //     \Log::critical("Failed to run alerts:check artisan command");
                    //     \Log::critical($th->getMessage());
                    // }

                }
            } catch (PDOException $e) {
                Log::critical("Connection failed: " . $e->getMessage());
            }
        }

        CheckAlertsJob::dispatch();
    }
}
