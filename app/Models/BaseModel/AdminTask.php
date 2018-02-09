<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class AdminTask extends Model
{
    protected $fillable = ['admin_id','submission_id','submission_event_id'];

    public function submission() {
        return $this->belongsTo(Submission::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}
