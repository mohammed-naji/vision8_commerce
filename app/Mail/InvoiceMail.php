<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $invname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $invname)
    {
        $this->name = $name;
        $this->invname = $invname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invoice')->attach(public_path('invoices/'.$this->invname));
    }
}
