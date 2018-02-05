<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{

    protected $fillable = ['value'];

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function getSetting($name, $default = null) {
        $find = self::where('name', $name)->first();
        if(empty($find))
            return $default;
        return $find->value;
    }

    public static function setSetting($name, $value) {
        return self::where('name','=', $name)->first()->update(['value' => $value]);
    }
}
