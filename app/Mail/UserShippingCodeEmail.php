<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class UserShippingCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $codigoEnvio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $codigoEnvio)
    {
        $this->user = $user;
        $this->codigoEnvio = $codigoEnvio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.shipping-code')
        ->with('userName', $this->user->name)
        ->with('shippingCode', $this->codigoEnvio);
    }
}
