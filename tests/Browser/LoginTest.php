<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase {

    protected $user;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample() {
        $this->browse(function (Browser $browser) {

            $this->user = User::factory()->create([
                'email' => 'usertest@gmail.com',
                'password' => bcrypt('qwe123qwe123')
            ]);

            $browser->visit('/login')
                ->type('email', $this->user->email)
                ->type('password', 'qwe123qwe123')
                ->press('Login')
                ->visit('/home')
                ->assertSee('Logout');
        });
    }

    protected function tearDown(): void {
        $this->user->delete();
        parent::tearDown();
    }
}
