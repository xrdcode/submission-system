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
    // DO NOT CHANGE !!
    const ABSTRACT_REVIEW = 1;
    const AFTER_APPROVED = 2;
    const AFTER_PAID = 3;
    const AFTER_UPLOAD_PAPER = 4;

    const EVENT_FOR_LIST = [0 => 'Participant', 1 => 'Non-Participant' ];

    const OCCUPATION = [0 => "All", 1 => "Student", 2 => "Non-Student"];
    const OCCUPATION_R = ["All" => 0, "Student" => 1,"Non-Student" => 2];
}