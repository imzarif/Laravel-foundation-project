<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ToGMOnConceptCreate extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $partnerName =  $this->details['partner_name'];
        return $this->subject("[NOTIFICATION] Concept Submitted by $partnerName")->view('emails.to-GM-concept-create');
    }
}
