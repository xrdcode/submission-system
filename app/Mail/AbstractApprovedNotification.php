<?php

namespace App\Mail;

use App\Models\BaseModel\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AbstractApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $submision;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Submission $submission)
    {
        $this->submision = $submission;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $submission = $this->submision;
        return $this->view('email.abstract', compact('submission'));
    }
}
