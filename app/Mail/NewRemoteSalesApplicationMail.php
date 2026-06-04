<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\RemoteSalesApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

final class NewRemoteSalesApplicationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly RemoteSalesApplication $application,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf(
                'New Remote Sales Application #%d — %s',
                $this->application->id,
                $this->application->telegram_username,
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.remote-sales.new-application',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function attachments(): array
    {
        return [];
    }
}
