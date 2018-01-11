<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class PaymentSubmission extends Model
{

    protected $fillable = ['submission_id','pricing_id','file'];

    public function submission() {
        return $this->belongsTo(Submission::class);
    }

    public function pricing() {
        return $this->belongsTo(Pricing::class);
    }

    public function waitingPayment() {
        return $this->where("verified","<>",1)->get();
    }
}
