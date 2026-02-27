<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TicketReplyMail extends Mailable
{
    public $ticket;
    public $reply;

    public function __construct($ticket, $reply)
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Your Ticket Has Been Updated')
                    ->view('emails.ticket_reply');
    }
}