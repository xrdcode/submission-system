<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{

    protected $fillable = ['price','submission_event_id','pricing_type_id'];

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
}
