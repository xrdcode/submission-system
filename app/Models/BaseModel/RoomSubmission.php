<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class RoomSubmission extends Model
{

    protected $dates = [
        'datetimes',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ["room_id","submission_id","datetimes"];

    protected $attributes = [
      'queue' => 0,
    ];

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

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

