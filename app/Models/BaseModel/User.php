<?php

namespace App\Models\BaseModel;

use App\Models\BaseModel\Biodata;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Notification\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','address','email_token','api_token','birthdate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

    public function general_payments() {
        return $this->hasMany(GeneralPayment::class);
    }

    public function payment_notification() {
        $data = $this->submissions()->whereHas('payment_submission', function($q) {
           $q->whereNull('file');
        })->with(['payment_submission']);

        return $data;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
