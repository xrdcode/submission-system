<?php

namespace App\Models\BaseModel;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SubmissionEvent extends Model
{
    protected $fillable = ['name','description', 'valid_from','valid_thru','submission_event_id', 'workstate_id'];



    protected $dates = [
        'valid_from',
        'valid_thru',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function parent() {
        return $this->belongsTo(SubmissionEvent::class, 'parent_id');
    }

    public function childs() {
        return $this->hasMany(SubmissionEvent::class, 'parent_id');
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function pricings() {
        return $this->hasMany(Pricing::class);
    }

    public function event_schedules() {
        return $this->hasOne(EventSchedule::class);
    }

    public function createdby() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedby() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function parentlist() {
        $parent = self::whereNull('parent_id')->get();
        $tmp = [];
        foreach ($parent as $p) {
            $tmp[$p->id] = $p->name;
        }
        return $tmp;
    }

    public function myParentList() {
        $parent = $this->whereNull('parent_id')->where('id', "!=", $this->id)->get();
        $tmp = [];
        foreach ($parent as $p) {
            $tmp[$p->id] = $p->name;
        }
        return $tmp;
    }

    public static function getlist() {
        $now = Carbon::now();
        $parent = self::where('valid_from', '<=', $now)
            ->where('valid_thru','>=', $now)
            ->whereNotNull('parent_id')
            ->get();
        $tmp = [];
        foreach ($parent as $p) {
            $tmp[$p->id] = $p->name . " | " . $p->parent->name;
        }
        return $tmp;
    }


}
