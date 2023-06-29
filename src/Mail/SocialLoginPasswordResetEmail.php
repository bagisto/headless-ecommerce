<?php

namespace Webkul\GraphQLAPI\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SocialLoginPasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new mailable instance.
     *
     * @param  array  $verificationData
     * @return void
     */
    public function __construct(public $data)
    {
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\View\View
     */
    public function build()
    {
        return $this->from(core()->getSenderEmailDetails()['email'], core()->getSenderEmailDetails()['name'])
            ->to($this->data['email'])
            ->subject(trans('bagisto_graphql::app.mail.customer.password.reset'))
            ->view('bagisto_graphql::shop.default.emails.customer.password-reset-email')
            ->with('data', $this->data);
    }
}