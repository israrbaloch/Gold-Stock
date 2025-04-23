<?php

namespace Tests\Unit;

use App\Providers\MonerisServiceProvider;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MonerisServiceTest extends TestCase {
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example() {
        $service = $this->app->make(MonerisServiceProvider::class);
        $this->assertInstanceOf(MonerisServiceProvider::class, $service);

        Log::info('MonerisServiceProvider processPayment called');
        $response = $service->processPayment();
        $this->assertEquals('true', $response->getComplete());

        Log::debug(get_object_vars($response));
    }
}
