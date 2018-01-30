<?php

namespace App\Models\BaseModel;

use App\Helper\Constant;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{

    protected $fillable = ['price','submission_event_id','pricing_type_id','isparticipant','title','usd_price','occupation'];

    public function payment_submissions() {
        return $this->hasMany(PaymentSubmission::class);
    }

    public function general_payments() {
        return $this->hasMany(GeneralPayments::class);
    }

    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function pricing_type() {
        return $this->belongsTo(PricingType::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function getOccupationAtribute($value) {
        if(empty($value)) return "";
        return Constant::OCCUPATION_R[$value];
    }

    public function setOccupationAttribute($value) {
        if(empty($value)) return "";
        $this->attributes['occupation'] = Constant::OCCUPATION[$value];
    }
}
