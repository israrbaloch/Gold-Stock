<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GoldStockMail extends Mailable {
    use Queueable, SerializesModels;
    public $subject;
    public $data;
    public $view;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
        $this->subject = $data['Subject'];
        $this->view = $data['View'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        if (isset($this->data['file'])) {
            $fileName = $this->data['filename'] . "." . $this->data['ext'];
            $mime = 'image/' . $this->data['ext'];
            return $this->subject($this->subject)->view('emails.' . $this->view, $this->data)->attach($this->data['file'], array('as' => $fileName, 'mime' => $mime));
        } else {
            return $this->subject($this->subject)->view('emails.' . $this->view, $this->data);
        }
    }
}
