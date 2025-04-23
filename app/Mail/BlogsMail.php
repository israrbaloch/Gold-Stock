<?php

namespace App\Mail;

use App\Mail\Promotions\GenericMail;
use App\Models\Blog;

class BlogsMail extends GenericMail {

    public string $_name = 'Blogs - Select 3';

    public $view = 'admin.mails.templates.blogs';

    public ?Blog $blog1 = null;
    public ?Blog $blog2 = null;
    public ?Blog $blog3 = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = []) {
        $this->blog1 = $data['blog1'] ?? null;
        $this->blog2 = $data['blog2'] ?? null;
        $this->blog3 = $data['blog3'] ?? null;
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
