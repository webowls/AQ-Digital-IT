<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactConfirmation extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(
    public readonly array $contactData,
    public readonly string $appName,
  ) {}

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'We received your message – ' . $this->appName,
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'emails.contact-confirmation',
    );
  }
}
