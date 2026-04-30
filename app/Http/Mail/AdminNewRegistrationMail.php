<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendingRegistration;
    public $adminUrl;

    /**
     * Create a new message instance.
     *
     * @param  object  $pendingRegistration
     * @param  string  $adminUrl
     * @return void
     */
    public function __construct($pendingRegistration, $adminUrl)
    {
        $this->pendingRegistration = $pendingRegistration;
        $this->adminUrl = $adminUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New User Registration - Pending Approval')
                    ->view('emails.admin-new-registration', [
                        'logo_url' => asset('images/download.jpg'),
                        'pendingRegistration' => $this->pendingRegistration,
                        'adminUrl' => $this->adminUrl
                    ]);
    }
}