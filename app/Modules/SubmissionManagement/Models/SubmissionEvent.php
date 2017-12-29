<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 5:03
 */

namespace App\Modules\SubmissionManagement\Models;

use App\Models\BaseModel\SubmissionEvent as BaseSubmissionEvent;

class SubmissionEvent extends BaseSubmissionEvent
{
    public function getParentList() {
        return self::whereNull('parent_id')->get();
    }
}