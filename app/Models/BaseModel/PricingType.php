<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class PricingType extends Model
{

    protected $fillable = ['name','description'];

    public function pricings() {
        return $this->hasMany(Pricing::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function getList() {
        $type = self::all()->where('active','=',1);
        $tmp = [];
        foreach ($type as $t) {
            $tmp[$t->id] = $t->name;
        }
        return $tmp;
    }
}
