<?php

namespace App\Mail;

use App\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorRegistrationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = '[Supplier Portal] Vendor Registration Notification';

    protected $vendor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendor-registration-notification')
            ->with(['vendor' => $this->vendor]);
    }
}
