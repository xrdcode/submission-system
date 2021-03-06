<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $fillable = ['name', 'number','address','building','notes'];

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
