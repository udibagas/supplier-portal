<?php

namespace App\Mail;

use App\VendorInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = '[Supplier Portal] Vendor Invitation';

    protected $vendorInvitation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VendorInvitation $vendorInvitation)
    {
        $this->vendorInvitation = $vendorInvitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendor-invitation')
            ->with(['invitation' => $this->vendorInvitation]);
    }
}
