<?php

namespace App\DTO;

use DateTime;

class CurrencyDTO {
    public string $currency;
    public float $value;
    public float $change;
    public float $change_percent;
    public float $weekly_change;
    public float $weekly_change_percent;
    public float $monthly_change;
    public float $monthly_change_percent;
    public float $yearly_change;
    public float $yearly_change_percent;
    public float $ask;
    public float $bid;
    public float $daily_lowest;
    public float $daily_highest;
    public float $open_today;
    public DateTime $date;
    public string $type;

    public function __construct(array $data) {
        $this->currency = $data['currency'];
        $this->value = (float)$data['value'];
        $this->change = (float)$data['change'];
        $this->change_percent = (float)$data['change_percent'];
        $this->weekly_change = (float)$data['weekly_change'];
        $this->weekly_change_percent = (float)$data['weekly_change_percent'];
        $this->monthly_change = (float)$data['monthly_change'];
        $this->monthly_change_percent = (float)$data['monthly_change_percent'];
        $this->yearly_change = (float)$data['yearly_change'];
        $this->yearly_change_percent = (float)$data['yearly_change_percent'];
        $this->ask = (float)$data['ask'];
        $this->bid = (float)$data['bid'];
        $this->daily_lowest = (float)$data['daily_lowest'];
        $this->daily_highest = (float)$data['daily_highest'];
        $this->open_today = (float)$data['open_today'];
        $this->date = new DateTime($data['date']);
        $this->type = $data['type'];
    }
}
