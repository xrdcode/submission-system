<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = ['name','description'];


    public function groups() {
        return $this->belongsToMany(Group::class);
    }
}
