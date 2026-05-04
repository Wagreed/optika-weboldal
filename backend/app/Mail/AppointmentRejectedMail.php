<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Appointment $appointment,
        public readonly string $recipientName,
        public readonly ?string $reason = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Időpont kérés elutasítva – Optika');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.appointment-rejected');
    }
}
