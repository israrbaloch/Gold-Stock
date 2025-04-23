<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class fillHistoricalPrice extends Command
{
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
    {   \Log::info("Price is working fine!");
        $asset_code_array = array("XAU/USD", "XAG/USD", "XPT/USD", "XPD/USD");
        $table_prefix = "ic_";

        foreach($asset_code_array as $asset)
        {
            $table = "";
            $url = 'https://currencydatafeed.com/api/data.php?token=y9gu5bjyi5mssl7w7dmj&currency=';
            if($asset == 'XAU/USD')
            {
                $table = $table_prefix.'historical_price_gold';
            }
            else if($asset == 'XAG/USD')
            {
                $table = $table_prefix.'historical_price_silver';
            }
            else if($asset == 'XPT/USD')
            {
                $table = $table_prefix.'historical_price_plat';
            }
            else if($asset == 'XPD/USD')
            {
                $table = $table_prefix.'historical_price_pall';
            }
            $url = $url.$asset;

            $contents = file_get_contents($url);
            $results = json_decode($contents);

            $value = $results->currency[0]->value;
            $change_value = $results->currency[0]->change;
            $change_percent = $results->currency[0]->change_percent;
            $ask = $results->currency[0]->ask;
            $bid = $results->currency[0]->bid;
            $daily_lowest = $results->currency[0]->daily_lowest;
            $daily_highest = $results->currency[0]->daily_highest;
            $date = $results->currency[0]->date;
            $type = $results->currency[0]->type;

            $timestamp = time();
            try 
            {
                $result = DB::table($table)->select('id')->where('value_date', $date)->count();
                if($result < 1){
                   DB::table($table)->insert([
                           'current_value'=>$value,
                           'change_value'=>$change_value,
                           'change_percent'=>$change_percent,
                           'ask'=>$ask,
                           'bid'=>$bid,
                           'daily_lowest'=>$daily_lowest,
                           'daily_highest'=>$daily_highest,
                           'value_date'=>$date,
                           'current_type' => $type,
                           'timestamp' => $timestamp
                   ]);
                }

            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
}
