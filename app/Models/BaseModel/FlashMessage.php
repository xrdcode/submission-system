<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class FlashMessage extends Model
{
    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
