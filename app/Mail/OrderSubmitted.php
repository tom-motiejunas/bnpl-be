<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /** @param array<string, array<float>> $order */
    public function __construct(public array $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Submitted',
        );
    }

    public function content(): Content
    {
        /** @var array<string, string> $order */
        $order = $this->order;

        return new Content(
            view: 'confirmOrder'
        );
    }
}
