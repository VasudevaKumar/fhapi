<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class fh extends Mailable
{
    use Queueable, SerializesModels;
    public $link = '';
    public $subject = '';
    public $name = '';
    public $activationCode = '';
    public $template = 'my-email';


    /**
     * Create a new message     instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view($this->template , ['link' => $this->link, 'name'=>$this->name, 'activationCode'=>$this->activationCode]);
    }
}
