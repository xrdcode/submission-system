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
        $user = $submission->user->personal_data->student == 0 ? "Non-Student" : "Student";
        $submission_type = $submission->submission_type_id == 1 ? "Presenter" : "Non Presenter"; // 1 presenter or 2 not presenter
        $pricing = $submission->submission_event->pricings()
            ->where("title","LIKE", "{$submission_type}%")
            ->where("occupation","=",$user)->first();
        return $this->view('email.abstract', ["submission" => $submission, "pricing" => $pricing]);
    }
}
