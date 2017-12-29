<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class RoomSubmission extends Model
{
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}

