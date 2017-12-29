<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{

    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function pricing_type() {
        return $this->belongsTo(PricingType::class);
    }
}
