<?php

namespace App\Services;

use App\DTO\CandleDTO;
use App\DTO\CurrencyWebSocketDTO;
use App\Events\HistoricalEvent;
use App\Events\ServerHistoricalEvent;
use Cache;
use Carbon\Carbon;
use Log;
use Ratchet\Client\WebSocket;
use Ratchet\Client\Connector;
use Ratchet\RFC6455\Messaging\Message;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class HistoricalWebSocketService {

    protected LoopInterface $loop;
    protected Connector $connector;
    protected $ws;

    protected $wsUrl = "wss://ws.currencydatafeed.com";
    private $subscription = "subscribe_XAU/USD+XAG/USD+XPT/USD+XPD/USD+USD/CAD+EUR/USD";

    private $login;
    private $loginMessage = "Please login in 10 seconds";
    private $subscriptionMessage = "Login success";

    private $masterMessage = "pusher:connection_established";
    private $masterSubscriptionMessage = "pusher_internal:subscription_succeeded";
    private $masterSubscription = '{"event":"pusher:subscribe","data":{"auth":"","channel":"server-historical-data"}}';


    private $MAX_LIST_SIZE = 20;

    public function __construct() {
        $this->login = config('services.datafeed.email') . ":" . config('services.datafeed.token');

        $this->loop = Loop::get();
        $this->connector = new Connector($this->loop);
    }

    public function run() {
        $this->connect();
        $this->loop->run();
    }

    public function connect() {
        if (config('websockets.master.enabled')) {
            Log::info("Connecting to master");
            $host = config('websockets.master.host');
            $port = config('websockets.master.port', null);
            if ($port != null) {
                $port = ":" . $port;
            }
            $key = config('broadcasting.connections.pusher.key');
            $url = "{$host}{$port}/app/{$key}";
        } else {
            Log::info("Connecting to CDF");
            $url = $this->wsUrl;
        }

        Log::info("Connecting to: " . $url);

        $this->connector->__invoke($url)
            ->then(function (WebSocket $conn) {
                Log::info("Connected");
                $this->ws = $conn;
                if (config('websockets.master.enabled')) {
                    $conn->on('message', [$this, 'handleMessageMaster']);
                } else {
                    $conn->on('message', [$this, 'handleMessageCDF']);
                }
                $conn->on('close', [$this, 'handleClose']);
                $conn->on('error', [$this, 'handleError']);
            }, function ($e) {
                Log::error("Could not connect: {$e->getMessage()}");
                Log::error("Reconnecting in 5 seconds");
                $this->reconnect();
            });

        gc_collect_cycles();
    }

    public function handleMessageMaster(Message $msg) {
        try {
            $json = json_decode($msg->getPayload(), true);
            if (strpos($json['event'], $this->masterMessage) !== false) {
                Log::debug("Login to the master websocket");
                $this->ws->send($this->masterSubscription);
            } else if (strpos($json['event'], $this->masterSubscriptionMessage) !== false) {
                Log::debug("Subscribed to the master websocket");
            } else {
                $json = json_decode($json['data'], true);
                $this->processMessage($json['data']);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Log::error($msg);
            Log::debug("Error processing message");
        }
    }
    public function handleMessageCDF(Message $msg) {
        try {
            if (strpos($msg, $this->loginMessage) !== false) {
                Log::debug("Login to the websocket");
                $this->ws->send($this->login);
            } elseif (strpos($msg, $this->subscriptionMessage) !== false) {
                Log::debug("Subscribing to the websocket");
                $this->ws->send($this->subscription);
            } else {
                $this->processMessage($msg);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Log::error($msg);
            Log::debug("Error processing message");
        }
    }

    public function handleClose($code = null, $reason = null) {
        Log::error("Connection closed ({$code} - {$reason})");
        $this->reconnect();
        gc_collect_cycles();
    }

    public function handleError($e) {
        Log::error("Connection error: {$e->getMessage()}");
    }

    protected function reconnect() {
        $this->loop->addTimer(5, function () {
            $this->connect();
        });
    }

    protected function processMessage(string $msg) {
        $json = null;
        try {
            $json = json_decode($msg, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                foreach ($json as $item) {
                    $dto = new CurrencyWebSocketDTO($item);
                    $this->processDTO($msg, $dto);
                }
            } else {
                Log::error("JSON decoding error: " . json_last_error_msg());
                Log::error($msg);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Log::error($msg);
            Log::debug("Error processing message");
        }
        gc_collect_cycles();
    }

    protected function processDTO($msg, CurrencyWebSocketDTO $dto) {
        if ($dto == null) {
            return;
        }

        switch ($dto->getSymbol()) {
            case 'XAU/USD':
                Cache::forever('exchange_gold', $dto);
                $this->setAskBidCache('gold', $dto);
                $this->processIntervals('gold', $dto);
                break;
            case 'XAG/USD':
                Cache::forever('exchange_silver', $dto);
                $this->setAskBidCache('silver', $dto);
                $this->processIntervals('silver', $dto);
                break;
            case 'XPT/USD':
                Cache::forever('exchange_platinum', $dto);
                $this->setAskBidCache('platinum', $dto);
                $this->processIntervals('platinum', $dto);
                break;
            case 'XPD/USD':
                Cache::forever('exchange_palladium', $dto);
                $this->setAskBidCache('palladium', $dto);
                $this->processIntervals('palladium', $dto);
                break;
            case 'USD/CAD':
                Cache::forever('exchange_cad', $dto);
                break;
            case 'EUR/USD':
                $dto->value = 1 / $dto->value;
                Cache::forever('exchange_eur', $dto);
                break;
            default:
                Log::critical("Symbol not found: " . $dto->getSymbol());
                break;
        }
        try {
            event(new HistoricalEvent($dto));
            // Log::debug("HistoricalEvent " . $dto->getSymbol() . " Sended");
            echo "HistoricalEvent " . $dto->getSymbol() . " Sended\n";
            if (!config('websockets.master.enabled')) {
                event(new ServerHistoricalEvent($msg));
                Log::debug("ServerHistoricalEvent Sended");
                echo "ServerHistoricalEvent Sended\n";
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        gc_collect_cycles();
    }

    public function __destruct() {
        // Ensure loop and connector are properly closed
        $this->loop->stop();
        unset($this->connector);
    }

    private function setAskBidCache($prefix, CurrencyWebSocketDTO $dto) {
        // ask
        $askList = Cache::get('exchange_' . $prefix . '_ask', []);
        array_unshift($askList, $dto->ask);
        if (count($askList) >= $this->MAX_LIST_SIZE) {
            array_pop($askList);
        }
        Cache::forever('exchange_' . $prefix . '_ask', $askList);

        // bid
        $bidList = Cache::get('exchange_' . $prefix . '_bid', []);
        array_unshift($bidList, $dto->bid);
        if (count($bidList) >= $this->MAX_LIST_SIZE) {
            array_pop($bidList);
        }
        Cache::forever('exchange_' . $prefix . '_bid', $bidList);
    }

    private function processIntervals($prefix, CurrencyWebSocketDTO $dto) {
        try {
            $this->processInterval($prefix, $dto, '1m');
            $this->processInterval($prefix, $dto, '5m');
            $this->processInterval($prefix, $dto, '15m');
            $this->processInterval($prefix, $dto, '1h');
            $this->processInterval($prefix, $dto, '1d');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        gc_collect_cycles();
    }

    private function processInterval($prefix, CurrencyWebSocketDTO $dto, $interval) {
        $key = 'exchange_' . $prefix . '_interval_' . $interval . '_candle';
        $candle = Cache::get($key, new CandleDTO());
        $time = $this->getTimeForInterval($interval);
        if ($time != $candle->timestamp) {
            $candle = new CandleDTO();
            $candle->symbol = $prefix;
            $candle->close = $dto->value;
            if ($interval == '1d') {
                $candle->open = $dto->open_today;
                $candle->high = $dto->daily_highest;
                $candle->low = $dto->daily_lowest;
            } else {
                $candle->open = $dto->value;
                $candle->high = $dto->value;
                $candle->low = $dto->value;
            }
            $candle->timestamp = $time;
        } else {
            $candle->close = $dto->value;
            if ($interval == '1d') {
                if ($dto->daily_highest > $candle->high) {
                    $candle->high = $dto->daily_highest;
                }
                if ($dto->daily_lowest < $candle->low) {
                    $candle->low = $dto->daily_lowest;
                }
            } else {
                if ($dto->value > $candle->high) {
                    $candle->high = $dto->value;
                }
                if ($dto->value < $candle->low) {
                    $candle->low = $dto->value;
                }
            }
        }
        Cache::forever($key, $candle);
    }

    private function getTimeForInterval($interval) {
        $now = Carbon::now('Europe/Helsinki');
        $now->setTime((int)$now->format('H'), (int)$now->format('i'), 0);

        switch ($interval) {
            case '1m':
                break;
            case '5m':
                $minute = floor((int)$now->format('i') / 5) * 5;
                $now->setTime((int)$now->format('H'), $minute, 0);
                break;
            case '15m':
                $minute = floor((int)$now->format('i') / 15) * 15;
                $now->setTime((int)$now->format('H'), $minute, 0);
                break;
            case '1h':
                $now->setTime((int)$now->format('H'), 0, 0);
                break;
            case '1d':
                $now->setTime(0, 0, 0);
                break;
            default:
                throw new \Exception("Invalid interval: " . $interval);
        }

        return $now->getTimestamp();
    }
}
