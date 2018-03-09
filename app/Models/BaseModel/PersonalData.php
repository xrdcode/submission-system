<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $fillable = ['institution','department','student','nik','identity_type_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }



}
