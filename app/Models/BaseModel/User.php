<?php

namespace App\Models\BaseModel;

use App\Models\BaseModel\Biodata;
use App\Models\BaseModel\GeneralPayments;
use App\Models\BaseModel\Submission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function biodatas() {
        return $this->hasOne(Biodata::class);
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function general_payments() {
        return $this->hasMany(GeneralPayments::class);
    }
}
