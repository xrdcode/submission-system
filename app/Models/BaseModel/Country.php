<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public static function lists() {
        $c = self::all()->sortBy('name');
        $tmp = [];
        foreach ($c as $d) {
            $tmp[$d->id] = $d->name;
        }
        return $tmp;
    }
}
