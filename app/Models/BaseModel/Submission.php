<?php

namespace App\Models\BaseModel;

use App\Helper\Constant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

    protected $fillable = ['title','abstract','feedback','abstractfile','user_id','submission_event_id','workstate_id','submission_type_id','file_paper_id','ispublicationonly'];

    public function user() {
        return $this->belongsTo(User::class)->where("deleted", 0);
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

    public function publication() {
        return $this->hasOne(Submission::class,'submission_id');
    }

    public function submission_event() {
        return $this->belongsTo(SubmissionEvent::class);
    }

    public function payment_submission() {
        return $this->hasOne(PaymentSubmission::class);
    }

    public function room_submission() {
        return $this->belongsTo(RoomSubmission::class);
    }

    public function pricelist() {
        $isstudent = $this->user->personal_data->student ? "Student" : "Non-Student";
        $filter = $this->ispublicationonly ? "Publication" : "Conference and Workshop";
        $price = $this->submission_event->pricings()
            ->where('isparticipant','=', 1)
            ->where('occupation','=', $isstudent)
            ->orWhere('occupation','=', "All")
            ->get();
        $tmp = [];
        foreach ($price as $p) {
            if($p->pricing_type->name == $filter)
                $tmp[$p->id] = "{$p->pricing_type->name} | $isstudent | IDR {$p->price} | USD {$p->usd_price}";
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

    public function admin_task() {
        return $this->hasOne(AdminTask::class);
    }

    public function reviewer() {
        if(!empty($this->admin_task))
            return $this->admin_task->admin();
        return null;
    }

    public function assignReviewer(Admin $admin, $notes = null) {
        if(empty($this->admin_task)) {
            $at = new AdminTask();
        } else {
            $at = $this->admin_task;
        }
        $at->name = $admin->name;
        if(!empty($notes))
            $at->notes = $admin->notes = $notes;
        $at->submission()->associate($this);
        $at->admin()->associate($admin);
        return $at->save();
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

    public function create_publication() {
        if(empty($this->publication)) {
            $pub = new Submission();
            $pub->title = $this->title;
            $pub->abstract = $this->abstract;
            $pub->user_id = $this->user_id;
            $pub->ispublicationonly = 1;
            $pub->abstractfile = $this->abstactfile;
            $pub->submission_event_id = $this->submission_event_id;
            $pub->submission_type_id = $this->submission_type_id;
            $pub->approved = 0;
            $pub->submission_id = $this->id;
            return $pub->save();
        }
        return false;
    }

}
