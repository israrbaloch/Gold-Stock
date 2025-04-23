<?php

namespace App\Mail;

use App\Mail\Promotions\GenericMail;
use App\Models\HomeNew;


class NewsMail extends GenericMail {

    public string $_name = 'News - Select 3';

    public $view = 'admin.mails.templates.news';

    public ?HomeNew $news1 = null;
    public ?HomeNew $news2 = null;
    public ?HomeNew $news3 = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = []) {
        $this->news1 = $data['news1'] ?? null;
        $this->news2 = $data['news2'] ?? null;
        $this->news3 = $data['news3'] ?? null;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view($this->view);
    }
}
