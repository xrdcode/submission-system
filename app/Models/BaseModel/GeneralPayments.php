<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class GeneralPayments extends Model
{
    public function pricing() {
        return $this->belongsTo(Pricing::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function workstate() {
        return $this->belongsTo(Workstate::class);
    }
}
