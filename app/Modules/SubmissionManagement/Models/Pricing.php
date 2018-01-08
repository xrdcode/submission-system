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
        $event = SubmissionEvent::whereNotNull('parent_id')->get();
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
        $price = SubmissionEvent::find($id)->pricings;
        $used = [];
        foreach($price as $p) {
            $used[] = $p->pricing_type->id;
        }

        $tmp = [];
        foreach (PricingType::all()->where('active','=', 1) as $pt) {
            if(!in_array($pt->id, $used)) {
                $tmp[$pt->id] = $pt->name;
            }
        }
        return $tmp;
    }


}