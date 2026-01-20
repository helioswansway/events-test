<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailCustomerCode extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;



    public $customer_name;
    public $customer_number;
    public $dealership_event;
    public $event_dates;

    public function __construct($customer_name, $customer_number, $dealership_event, $event_dates)
    {

        $this->customer_name = $customer_name;
        $this->customer_number = $customer_number;
        $this->dealership_event = $dealership_event;
        $this->event_dates = $event_dates;
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {

        return new Envelope(
            from: new Address('no-reply@swanswaygroup.com', 'Swansway Group Events'),
            subject: 'Your Registration Event Code',
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
            markdown: 'emails.email-customer-code',
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
