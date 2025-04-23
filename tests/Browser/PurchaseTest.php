<?php

namespace Tests\Browser;

use App\Models\User;
use Cart;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PurchaseTest extends DuskTestCase {

    protected $email;
    protected $password;

    function signup(): void {
        $this->email = 'test' . rand(1, 1000) . '@example.com';
        $this->password = 'password123';

        $this->browse(function (Browser $browser) {
            // Test with all fields filled
            $browser->visit('/register')
                ->type('email', $this->email)
                ->type('password', $this->password)
                ->type('password_confirmation', $this->password)
                ->check('.form-check-input')
                ->press('Register')
                ->assertSee('Logout'); // Assuming the user is redirected to '/home' after registration

            $browser->visit('/registration-form')
                ->type('fname', 'John')
                ->type('lname', 'Doe')
                ->type('city', 'New York')
                ->select('province_id', '1')
                ->type('address_line1', '123 Main St')
                ->type('postcode', 'T7S1G6')
                ->type('phone', '1234567890')
                ->click('#submit');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSignupAndPurchase() {

        $this->signup();

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/shop')
                ->waitFor('#desktop-product-3454', 10)
                ->click('#desktop-product-3454 button')
                ->acceptDialog();

            $browser
                ->visit('/cart')
                ->waitForText('Shopping Cart', 10);

            // get total amount
            $subTotal = $browser->text('#total');

            $browser
                ->press('Proceed to Checkout');

            // Shipping
            $browser
                ->waitForText('Shipping Information', 5)
                ->waitFor('#progressButtonShipping', 5)
                ->scrollTo('#progressButtonShipping')
                ->script("document.querySelector('#progressButtonShipping').click();");

            // Summary
            $shipping = $browser->text('#shippingDescription');
            $dueNow = $browser->text('#dueNow');
            $initialDeposit = $browser->text('#initialDeposit');
            $fee = $browser->text('#fee');
            $total = $browser->text('#total');
            $pending = $browser->text('#pending');
            $browser
                ->waitFor('#progressButtonSummary', 5)
                ->assertSeeIn('#subtotal', $subTotal)
                ->script("document.querySelector('#progressButtonSummary').click();");

            $browser
                ->waitFor('#paymentMoneris', 5)
                ->script("document.querySelector('#paymentMoneris').click();");

            $browser
                ->waitFor('#monerisCheckout-Frame', 10)
                ->scrollIntoView('#monerisCheckout-Frame')
                ->withinFrame('#monerisCheckout-Frame', function (Browser $browser) use ($dueNow) {
                    $browser
                        ->waitFor('#cardholder', 10)
                        ->type('#cardholder', 'John Doe')
                        ->type('#pan', '5454545454545454')
                        ->type('#expiry_date', '1228')
                        ->type('#cvv', '123')
                        ->assertSeeIn('#txn_total', $dueNow)
                        ->scrollTo('#process')
                        ->press('Checkout')

                        ->assertSee('Processing transaction')
                        ->waitForText('Transaction Approved', 10);
                })
                ->waitForDialog(10)
                ->acceptDialog();

            $browser
                ->waitForText('Thanks for your order!', 10)
                ->assertSee('Thanks for your order!')
                ->assertSeeIn('#subtotal', $subTotal)
                ->assertSeeIn('#shipping', $shipping)
                ->assertSeeIn('#dueNow', $dueNow)
                ->assertSeeIn('#initialDeposit', $initialDeposit)
                ->assertSeeIn('#fee', $fee)
                ->assertSeeIn('#total', $total)
                ->assertSeeIn('#pending', $pending);
        });
    }

    protected function tearDown(): void {
        // Delete the user created during the test
        User::where('email', $this->email)->delete();
        parent::tearDown();
    }
}
