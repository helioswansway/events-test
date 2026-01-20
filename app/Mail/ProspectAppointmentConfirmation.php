<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class ProspectAppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;


    public $subject;
    public $appointment;
    public $event;
    public $book;
    public $exec;
    public $time;
    public $dealership;
    public $config;


    /**
     * Create a new message instance.
     */

     public function __construct($subject, $appointment, $event, $book, $exec, $time, $dealership, $config)
     {

         $this->subject = $subject;
         $this->appointment = $appointment;
         $this->event = $event;
         $this->book = $book;
         $this->exec = $exec;
         $this->time = $time;
         $this->dealership = $dealership;
         $this->config = $config;


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
            subject: $this->subject,
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
            view: 'emails.prospect-appointment-confirmation',
            with:[
                'appointment' => $this->appointment,
                'event' => $this->event,
                'book' => $this->book,
                'exec' => $this->exec,
                'time' => $this->time,
                'dealership' => $this->dealership,
                'config' => $this->config,
            ]
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
