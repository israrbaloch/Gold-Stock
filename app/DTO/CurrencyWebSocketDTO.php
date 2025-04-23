<?php

namespace App\DTO;

use Carbon\Carbon;

class CurrencyWebSocketDTO {

    public string $symbol;
    public string $currency;
    private string $name_en;
    public float $value;
    public float $change;
    public float $change_percent;
    private float $weekly_change;
    private float $weekly_change_percent;
    private float $monthly_change;
    private float $monthly_change_percent;
    private float $yearly_change;
    private float $yearly_change_percent;
    public float $ask;
    public float $bid;
    public float $daily_lowest;
    public float $daily_highest;
    public float $open_today;
    public Carbon $date;

    public function __construct(array $data = null) {
        if ($data === null) {
            return;
        }
        $this->symbol = $data['sembol'] ?? $data['symbol'];
        $this->name_en = $data['name_en'];
        $this->value = (float)$data['last'];

        $this->change = (float)$data['changenumber'];
        $this->weekly_change = (float)$data['weekChange'];
        $this->monthly_change = (float)$data['monthChange'];
        $this->yearly_change = (float)$data['yearChange'];

        $this->change_percent = (float)$data['changepercent'];
        $this->weekly_change_percent = (float)$data['weekPercent'];
        $this->monthly_change_percent = (float)$data['MonthPercent'];
        $this->yearly_change_percent = (float)$data['yearPercent'];

        $this->ask = (float)$data['ask'];
        $this->bid = (float)$data['bid'];

        $this->daily_lowest = (float)$data['low'];
        $this->daily_highest = (float)$data['high'];

        $this->open_today = (float)$data['prevClose'];
        $this->date = Carbon::parse($data['updated'])->setTimezone('Europe/Helsinki');

        $this->process();
    }

    private function process() {
        switch ($this->symbol) {
            case 'XAU/USD':
                $this->currency = 'Gold';
                break;
            case 'XAG/USD':
                $this->currency = 'Silver';
                break;
            case 'XPT/USD':
                $this->currency = 'Platinum';
                break;
            case 'XPD/USD':
                $this->currency = 'Palladium';
                break;
            case 'USD/CAD':
                $this->currency = 'Canadian';
                break;
            case 'EUR/USD':
                $this->currency = 'Euro';
                break;
            case 'USD':
                $this->currency = 'Dollar';
                break;
        }
    }

    public function __toString() {
        return json_encode($this);
    }

    public function getSymbol() {
        return $this->symbol;
    }
}
