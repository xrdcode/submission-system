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


    /**
     * Check if has publication pricings
     */
    public function hasPublication() {
        $pricing = $this->pricings;
        foreach ($pricing as $p) {
            if($p->pricing_type->name == "Publication")
                return true;
        }
        return false;
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
        $event = self::where('valid_from', '<=', $now)
            ->where('valid_thru','>=', $now)
            ->whereNotNull('parent_id')
            ->get();
        $tmp = [];
        foreach ($event as $e) {
            $tmp[$e->id] = $e->name . " | " . $e->parent->name;
        }
        return $tmp;
    }

    public static function getevpublist() {
        $now = Carbon::now();
        $event = self::where('valid_from', '<=', $now)
            ->where('valid_thru','>=', $now)
            ->whereNotNull('parent_id')
            ->get();
        $tmp = [];
        foreach ($event as $e) {
            if($e->hasPublication())
                $tmp[$e->id] = $e->name . " | " . $e->parent->name;
        }
        return $tmp;
    }

    public function publicationlist() {
        $price = $this->pricings;
        $tmp = [];
        foreach ($price as $p) {
            if($p->pricing_type->name == "Publication")
                $tmp[$p->id] = "{$p->title} | IDR {$p->price} | USD {$p->usd_price}";
        }
        return $tmp;
    }


}
