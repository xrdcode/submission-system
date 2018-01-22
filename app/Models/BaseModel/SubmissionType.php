<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class SubmissionType extends Model
{

    protected $fillable = ['name','description'];

    public function submission() {
        return $this->hasOne(Submission::class);
    }

    public static function getlist() {
        $type = self::all();
        $tmp = [];
        foreach ($type as $t) {
            $tmp[$t->id] = $t->name;
        }
        return $tmp;
    }
}
