<?php

namespace App\Models\BaseModel;

use App\Models\BaseModel\Biodata;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Notification\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password','phone','address','email_token','api_token','birthdate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token','email_token',
    ];
    public function personal_data() {
        return $this->hasOne(PersonalData::class);
    }

    public function personal_data_filled() {
        $pd = $this->personal_data;
        return !empty($pd) ? true : false;
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function submissionlist() {
        $submission = $this->submissions()->where('ispublicationonly','=','0')->get();
        $tmp = [];
        foreach ($submission as $s) {
            $tmp[$s->id] = $s->title;
        }
        return $tmp;
    }

    public function general_payments() {
        return $this->hasMany(GeneralPayment::class);
    }

    public function payment_notification() {
        $data = $this->submissions()->whereHas('payment_submission', function($q) {
           $q->whereNull('file');
        })->with(['payment_submission']);

        return $data;
    }

    public function user_notifications() {
        return $this->hasMany(UserNotification::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function createNotification($title, $body, $class = '') {
        $un = new UserNotification();
        $un->title = $title;
        $un->body   = $body;
        $un->user()->associate($this);
        $un->admin()->associate(Auth::id());
        $un->class = $class;
        return $un->save();
    }

    public function hardDelete()
    {
        return parent::delete();
    }

    public function delete() {
        $this->deleted = 1;
        return $this->save();
    }

    public function undelete() {
        $this->deleted = 0;
        return $this->save();
    }
}
