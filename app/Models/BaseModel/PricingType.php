<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class PricingType extends Model
{
    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function getList() {
        $type = self::all();
        $tmp = [];
        foreach ($type as $t) {
            $tmp[$t->id] = $t->name;
        }
        return $tmp;
    }
}
