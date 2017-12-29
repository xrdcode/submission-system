<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class SubmissionEvent extends Model
{
    public function parent() {
        return $this->belongsTo(SubmissionEvent::class, 'parent_id');
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function event_schedules() {
        return $this->hasOne(EventSchedule::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
