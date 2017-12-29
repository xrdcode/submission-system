<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'pathname', 'description'];
}
