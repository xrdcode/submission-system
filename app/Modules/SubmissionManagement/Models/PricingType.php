<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 07/01/2018
 * Time: 19:08
 */

namespace App\Modules\SubmissionManagement\Models;

use App\Models\BaseModel\PricingType as BasePricingType;

class PricingType extends BasePricingType
{
    public function submissions() {
        return $this->hasMany(Submission::class);
    }
}