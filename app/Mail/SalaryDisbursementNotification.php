<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalaryDisbursementNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailData;
    protected $attachmentPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $attachmentPath)
    {
        $this->mailData = $mailData;
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Salary Disbursement Notification')
            ->view('staff.email')
            ->with('mailData', $this->mailData)
            ->attach($this->attachmentPath); // Attach the file
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
