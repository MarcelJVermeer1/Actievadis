<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class RegisterVerification extends Mailable {
    use Queueable, SerializesModels;

    /**
     * The user instance for the mail.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Bevestig je e-mailadres',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
        );

        return new Content(
            view: 'email.register_verification',
            with: ['user' => $this->user, 'url' => $verificationUrl],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array {
        return [];
    }
}
