<?php

namespace App\Mail\Promotions;

use App\Models\Product;


class PromoMail extends GenericMail {

    public string $_name = 'Promotion - 3 Products';

    public $view = 'admin.mails.templates.promo';

    public ?Product $product = null;
    public ?Product $product2 = null;
    public ?Product $product3 = null;

    public ?string $title = null;

    public ?string $description = null;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = []) {
        $this->product = $data['product'] ?? null;
        $this->product2 = $data['product2'] ?? null;
        $this->product3 = $data['product3'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
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
