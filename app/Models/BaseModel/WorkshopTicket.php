<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Model;

class WorkshopTicket extends Model
{
    protected $fillable = ['code','used'];

    public function general_payment() {
        return $this->belongsTo(GeneralPayment::class);
    }
}
