<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use App\Models\GuestEnrollment;

class GuestEnrollmentVerification extends Mailable {
    use Queueable, SerializesModels;

    public $guest;

    public function __construct(GuestEnrollment $guest) {
        $this->guest = $guest;
    }

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Bevestig je inschrijving',
        );
    }

    public function content(): Content {
        $verificationUrl = URL::temporarySignedRoute(
            'guest.enrollment.verify',
            now()->addMinutes(60),
            ['id' => $this->guest->id]
        );

        return new Content(
            view: 'email.guest_enrollment_verification',
            with: ['guest' => $this->guest, 'url' => $verificationUrl],
        );
    }

    public function attachments(): array {
        return [];
    }
}
