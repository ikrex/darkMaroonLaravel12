<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    /**
     * Create a new message instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $locale = Session::get('locale', 'hu');

        if ($locale === 'en') {
            $subject = 'Registration Confirmation';
        } else {
            $subject = 'Regisztráció visszaigazolása';
        }

        return $this->subject($subject)
                    ->view('emails.registration-confirmation');
    }
}
