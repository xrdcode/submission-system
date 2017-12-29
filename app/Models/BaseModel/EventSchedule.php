<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
