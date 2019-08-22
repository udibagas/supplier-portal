<?php

namespace App\Mail;

use App\VendorRegistrationReview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorRegistrationApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = '[Supplier Portal] Vendor Verification Approved';

    protected $review;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VendorRegistrationReview $review)
    {
        $this->review = $review;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendor-registration-approval')
            ->with(['review' => $this->review]);
    }
}
