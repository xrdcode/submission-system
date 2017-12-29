<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function identity_type() {
        return $this->belongsTo(IdentityType::class);
    }
}
