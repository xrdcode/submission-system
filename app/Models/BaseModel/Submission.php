<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function file_paper() {
        return $this->belongsTo(FilePaper::class);
    }

    public function submission_status() {
        return $this->belongsTo(SubmissionStatus::class);
    }

    public function workstate() {
        return $this->belongsTo(Workstate::class);
    }

    public function submission_event() {
        return $this->belongsTo(SubmissionStatus::class);
    }
}
