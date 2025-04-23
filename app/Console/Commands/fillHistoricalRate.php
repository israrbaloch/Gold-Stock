<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class fillHistoricalRate extends Command
{
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
        \Log::info("Cron Rate is working fine!");
        $table_prefix = "ic_";

        $table = $table_prefix.'historical_rate';


        $urlcad = 'https://currencydatafeed.com/api/data.php?token=y9gu5bjyi5mssl7w7dmj&currency=USD/CAD';
        $urleur = 'https://currencydatafeed.com/api/data.php?token=y9gu5bjyi5mssl7w7dmj&currency=USD/EUR';
        $urlcad_inverse = "https://currencydatafeed.com/api/data.php?token=y9gu5bjyi5mssl7w7dmj&currency=CAD/USD";
        $urleur_inverse = "https://currencydatafeed.com/api/data.php?token=y9gu5bjyi5mssl7w7dmj&currency=EUR/USD";

        $contentscad = file_get_contents($urlcad);
        $resultscad = json_decode($contentscad);

        $contentseur = file_get_contents($urleur);
        $resultseur = json_decode($contentseur);

        $contentscad_inverse = file_get_contents($urlcad_inverse);
        $resultscad_inverse = json_decode($contentscad_inverse);

        $contentseur_inverse = file_get_contents($urleur_inverse);
        $resultseur_inverse = json_decode($contentseur_inverse);

        $valueusd = 1;
        $valuecad = $resultscad->currency[0]->value;
        $valueeur= $resultseur->currency[0]->value;
        $valuecad_inverse = $resultscad_inverse->currency[0]->value;
        $valueeur_inverse= $resultseur_inverse->currency[0]->value;

        $timestamp = time();

        try 
        {
            DB::table($table)->insert([
                    'us_rate'=>$valueusd,
                    'cad_rate'=>$valuecad,
                    'eur_rate'=>$valueeur,
                    'cad_rate_inverse'=>$valuecad_inverse,
                    'eur_rate_inverse'=>$valueeur_inverse,
                    'timestamp' => $timestamp
            ]);
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
