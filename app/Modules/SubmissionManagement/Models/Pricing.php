<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 07/01/2018
 * Time: 19:10
 */

namespace App\Modules\SubmissionManagement\Models;

use App\Models\BaseModel\Pricing as BasePricing;
use App\Modules\SubmissionManagement\Models\SubmissionEvent;

class Pricing extends BasePricing
{
    public static function getEventList() {
        $event = SubmissionEvent::all();
        $tmp = [];
        foreach($event as $ev) {
            if($ev->pricings->count() < Pricing::all()->count()) {
                $tmp[$ev->id] = $ev->name;
            }
        }
        return $tmp;
    }

    /**
     * @return array
     *
     * Get remaining pricing type to create new price on event
     */
    public static function getTypeListByEvent($id) {
        $type = PricingType::all()->load('submissions');
        $tmp = [];
        foreach ($type as $t) {

        }
    }


}