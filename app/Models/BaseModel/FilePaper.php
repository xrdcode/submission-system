<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class FilePaper extends Model
{protected $fillable = ['name','type','submission_id','path','full_path'];
}
