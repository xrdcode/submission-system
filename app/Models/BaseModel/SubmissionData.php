<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class SubmissionData extends Model
{
    public function submission() {
        return $this->hasOne(Submission::class);
    }
}
