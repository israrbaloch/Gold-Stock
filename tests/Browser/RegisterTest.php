<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase {

    protected $userEmail;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample() {
        $this->browse(function (Browser $browser) {

            $this->userEmail = 'testUser' . rand(1, 1000) . '@example.com';
            $randomPassword = 'password123';

            // Test with empty fields
            $browser->visit('/register')
                ->press('Register')
                ->assertPathIs('/register'); // Assert that the URL is still '/register'

            // Test with only name filled
            $browser->visit('/register')
                ->type('email', $this->userEmail)
                ->press('Register')
                ->assertPathIs('/register'); // Assert that the URL is still '/register'

            // Test with all fields filled
            $browser->visit('/register')
                ->type('email', $this->userEmail)
                ->type('password', $randomPassword)
                ->type('password_confirmation', $randomPassword)
                ->check('.form-check-input')
                ->press('Register')
                ->assertSee('Logout'); // Assuming the user is redirected to '/home' after registration
        });
    }

    protected function tearDown(): void {
        // Delete the user created during the test
        User::where('email', $this->userEmail)->delete();
        parent::tearDown();
    }
}
