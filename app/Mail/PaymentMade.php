<?php

namespace App\Mail;

use App\Models\UserLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentMade extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<float>  $payments
     */
    public function __construct(public UserLoan $order, public array $payments)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Made',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'paymentMade',
        );
    }
}
