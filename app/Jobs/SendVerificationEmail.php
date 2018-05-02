<?php

namespace App\Jobs;

use App\Models\BaseModel\User;
use Mail;
use App\Mail\EmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $field = [
        'password' => null
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $custField = null)
    {
        $this->user = $user;
        if(is_array($custField)) {
            if (!empty($custField["password"])) {
                $this->field = $custField;
            }
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EmailVerification($this->user, $this->field);
        if(!$this->user->active)
            Mail::to($this->user->email)->send($email);
    }
}
