<?php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory {

    protected $model = Subscription::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'subscribed' => $this->faker->boolean,
        ];
    }
}
