<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\BaseModel\User;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $field = [
        'password' => null
    ];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $custField = null)
    {
        $this->user = $user;
        if (!empty($custField["password"])) {
            $this->field = $custField;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("email.verification")->with([
            'email_token' => $this->user->email_token,
            'username' => $this->user->name,
            'password' => $this->field["password"],
            'email' => $this->user->email
        ]);
    }
}
