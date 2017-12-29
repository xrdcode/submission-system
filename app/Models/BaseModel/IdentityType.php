<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class IdentityType extends Model
{
    public function biodatas() {
        return $this->hasMany(Biodata::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
