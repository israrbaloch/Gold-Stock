<?php

namespace App\Mail\Promotions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

abstract class GenericMail extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    public string $_name = 'Name';


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public abstract function build();
}
