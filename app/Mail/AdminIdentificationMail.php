<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminIdentificationMail extends Mailable {
    use Queueable, SerializesModels;

    public $fname;
    public $email;
    public $file;
    public $filename;
    public $ext;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->fname = $data['fname'];
        $this->email = $data['email'];
        $this->file = $data['file'] ?? null;
        $this->filename = $data['filename'] ?? null;
        $this->ext = $data['ext'] ?? null;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        if (isset($this->file)) {
            $fileName = $this->filename . "." . $this->ext;
            $mime = 'image/' . $this->ext;
            return $this
                ->view('emails.admin.identification')
                ->subject('New Identification Request')
                ->attach($this->file, array('as' => $fileName, 'mime' => $mime));
        } else {
            return $this
                ->view('emails.admin.identification')
                ->subject('New Identification Request');
        }
    }
}
