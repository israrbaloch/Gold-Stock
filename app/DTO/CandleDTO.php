<?php

namespace App\DTO;

use Carbon\Carbon;

class CandleDTO {
    public string $symbol;
    public int $timestamp = 0;
    public float $open;
    public float $close;
    public float $high;
    public float $low;

    public function __construct(array $data = null) {
        if ($data === null) {
            return;
        }
        $this->symbol = $data['symbol'];
        $this->timestamp = $data['timestamp'];
        $this->open = (float)$data['open'];
        $this->close = (float)$data['close'];
        $this->high = (float)$data['high'];
        $this->low = (float)$data['low'];
    }
}
