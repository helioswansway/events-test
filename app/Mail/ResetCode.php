<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetCode extends Mailable
{
    use Queueable, SerializesModels;


    public $customer_name;
    public $customer_number;


    public function __construct($customer_name, $customer_number)
    {

        $this->customer_name = $customer_name;
        $this->customer_number = $customer_number;

    }


    public function envelope()
    {

        return new Envelope(
            from: new Address('no-reply@swanswaygroup.com', 'Swansway Group Events'),
            subject: 'Your Reset Event Code',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.reset-code',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
