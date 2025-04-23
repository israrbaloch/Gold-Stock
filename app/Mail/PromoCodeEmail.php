<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromoCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $promoCode;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $promoCode
     */
    public function __construct($user, $promoCode)
    {
        $this->user = $user;
        $this->promoCode = $promoCode;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Promo Code from Gold Stock Canada')
            ->view('emails.user.promo_code')
            ->with([
                'name' => $this->user->name,
                'promoCode' => $this->promoCode,
                'discount' => $this->promoCode->getDiscountAmountWords(),
            ]);
    }
}

