<?php

namespace App\Mail;

use App\Models\GuestEnrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuestDeregistration extends Mailable {
    use Queueable, SerializesModels;

    public $guest;

    /**
     * Create a new message instance.
     */
    public function __construct(GuestEnrollment $guest) {
        $this->guest = $guest;
    }

    /**
     * Build the message.
     */
    public function build() {
        return $this->subject(__('Bedankt voor het deelnemen!'))
            ->view('email.guest_deregistration')
            ->with([
                'guest' => $this->guest,
                'deregistrationUrl' => route('guest.enrollment.deregister', ['id' => $this->guest->id, 'signature' => sha1($this->guest->id . config('app.key'))]),
            ]);
    }
}
