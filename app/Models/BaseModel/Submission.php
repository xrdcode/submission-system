<?php

namespace App\Models\BaseModel;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

    protected $fillable = ['title','abstract','feedback','abstractfile','user_id','submission_event_id','workstate_id','submission_type_id','file_paper_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function file_paper() {
        return $this->belongsTo(FilePaper::class);
    }

    public function submission_status() {
        return $this->belongsTo(SubmissionStatus::class);
    }

    public function submission_data() {
        return $this->belongsTo(SubmissionData::class);
    }

    public function submission_type() {
        return $this->belongsTo(SubmissionType::class);
    }

    public function workstate() {
        return $this->belongsTo(Workstate::class);
    }

    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function payment_submission() {
        return $this->hasOne(PaymentSubmission::class);
    }

    public function pricelist() {
        $price = $this->submission_event->pricings()->where('isparticipant','=', true);
        $tmp = [];
        foreach ($price as $p) {
            $tmp[$p->id] = "{$p->pricing_type->name} | Rp. {$p->price}";
        }
        return $tmp;
    }

    public function isPaid() {
        if(empty($this->payment_submission))
            return false;
        if($this->payment_submission->verified)
            return true;
        return false;
    }

    /**
     * Future Update
     */
    public function stepUpProgress() {
        $ws = $this->workstate;
        $nws = Workstate::where('order','=',$ws->order + 1)->first();
        $this->workstate()->associate($nws);
        $this->update();
    }

}
