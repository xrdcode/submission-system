<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class WorkstateType extends Model
{
    public static function GetSelectableList() {
        $wsts = self::all();
        $tmp = [];
        foreach ($wsts as $wst) {
            $tmp[$wst->id] = $wst->name;
        }
        return $tmp;
    }
}
