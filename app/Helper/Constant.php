<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 10/01/2018
 * Time: 16:53
 */

namespace App\Helper;


class Constant
{
    const WORKSTATE_ID_SUBMISSION = 1;
    const WORKSTATE_ID_PAYMENT = 2;

    // DO NOT CHANGE !!
    const ABSTRACT_REVIEW = 1;
    const AFTER_APPROVED = 2;
    const AFTER_PAID = 3;
    const AFTER_UPLOAD_PAPER = 4;

    //DO NOT CHANGE
    const WS_TRX_CONFIRM = 8;
    const WS_TRX_VERIFY = 9;
    const WS_CONFIRMED = 10;
    const WS_REJECTED = 11;

    const EVENT_FOR_LIST = [0 => 'Participant', 1 => 'Non-Participant' ];

    const OCCUPATION = [0 => "All", 1 => "Student", 2 => "Non-Student"];
    const OCCUPATION_R = ["All" => 0, "Student" => 1,"Non-Student" => 2];

    const BANK_LIST = ['BCA','BNI','BRI','BTN','CIMB Niaga','Danamon','Mandiri'];
}