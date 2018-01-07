<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 05/01/2018
 * Time: 15:03
 */

namespace App\Helper;


class AppHelper
{
    public static function getFileExtension($f) {
        $a = explode(".", $f);
        return last($a);
    }
}