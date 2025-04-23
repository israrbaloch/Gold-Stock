<?php

namespace App\Console\Commands;

use App\DTO\CurrencyDTO;
use Http;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Log;
use PDOException;

class HistoricalRateCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:cron';

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

        $code_array = array("USD/CAD", "USD/EUR", "CAD/USD", "EUR/USD");

        $url = 'https://currencydatafeed.com/api/data.php?token=' . config('services.datafeed.token') . '&currency=' . join("+", $code_array);

        $response = Http::get($url);
        $results = $response->json();

        $status = $results['status'];
        $currencies = array_map(fn ($currency) => new CurrencyDTO($currency), $results['currency']);

        if (config('app.env') == 'local') {
            Log::info($status == 1 ? "Success" : "Failed");
            Log::info($currencies);
        }

        if (!$status) {
            Log::critical("Failed to fetch data from currencydatafeed.com, with " . join(",", $code_array));
            return;
        }

        $cad = null;
        $eur = null;
        $cad_inverse = null;
        $eur_inverse = null;

        foreach ($currencies as $currency) {
            $table = "";

            switch ($currency->currency) {
                case 'USD/CAD':
                    $cad = $currency->value;
                    break;
                case 'USD/EUR':
                    $eur = $currency->value;
                    break;
                case 'CAD/USD':
                    $cad_inverse = $currency->value;
                    break;
                case 'EUR/USD':
                    $eur_inverse = $currency->value;
                    break;
                default:
                    Log::critical("Currency not found: " . $currency->currency);
                    continue 2;
            }
        }

        if ($cad == null || $eur == null || $cad_inverse == null || $eur_inverse == null) {
            Log::critical("Failed to fetch all data from currencydatafeed.com, with " . join(",", $code_array));
            return;
        }

        try {
            DB::table('ic_historical_rate')->insert([
                'us_rate' => 1,
                'cad_rate' => $cad,
                'eur_rate' => $eur,
                'cad_rate_inverse' => $cad_inverse,
                'eur_rate_inverse' => $eur_inverse,
                'timestamp' => time()
            ]);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
