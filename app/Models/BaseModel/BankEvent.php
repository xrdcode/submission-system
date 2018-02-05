<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class BankEvent extends Model
{

    protected $fillable = ['bank','number','name', 'notes','submission_event_id'];

    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        $this->belongsTo(Admin::class,'updated_by');
    }
}
