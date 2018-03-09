<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class GeneralPayment extends Model
{
    protected $fillable = ['submission_event_id','pricing_id','workstate_id','file','notes','user_id'];

    const VERIFIED  = [0 => 'Not Verified', 1 => 'Verified'];
    const VERIFIED_R  = ['Not Verified' => 0, 'Verified' => 1];

    public function pricing() {
        return $this->belongsTo(Pricing::class);
    }

    public function user() {
        return $this->belongsTo(User::class)->where("deleted", 0);
    }

    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function workstate() {
        return $this->belongsTo(Workstate::class);
    }

    public function getVerifiedAttribute($value) {
        if($value == 0) {
            return "Not Verified";
        } else {
            return "Verified";
        }
    }

    public function workshop_ticket() {
        return $this->hasOne(WorkshopTicket::class);
    }

    public function isPaid() {
        if($this->verified == "Verified")
            return true;
        return false;
    }
}
