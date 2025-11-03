<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $tickets;
    public $user;

    public function __construct($user, $event, $tickets)
    {
        $this->user = $user;
        $this->event = $event;
        $this->tickets = $tickets;
    }

    public function build()
    {
        return $this->subject('Your Event Ticket')
                    ->view('emails.ticket');
    }
}
