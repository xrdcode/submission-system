<?php

namespace App\Models\BaseModel;

use App\Helper\Constant;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{

    protected $dates = [
        "early_date_until",
    ];

    protected $fillable = ['price','submission_event_id','pricing_type_id','isparticipant','usd_price','title','occupation','early_date_until','early_price'];

    public function payment_submissions() {
        return $this->hasMany(PaymentSubmission::class);
    }

    public function general_payments() {
        return $this->hasMany(GeneralPayment::class);
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

    public function getOccupationAttribute($value) {
        return $value;
    }

    public function setOccupationAttribute($value) {
        if(!in_array($value, [0,1,2])) return Constant::OCCUPATION[0];
        $this->attributes['occupation'] = Constant::OCCUPATION[$value];
    }
}
