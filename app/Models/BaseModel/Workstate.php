<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Workstate extends Model
{
    protected $fillable = ['name', 'description','workstate_type_id'];

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

}
