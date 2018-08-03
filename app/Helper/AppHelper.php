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

    public static function formatCurrency($val, $delim = ",") {
        switch ($delim) {
            case ".":
                $value = number_format($val, 0, ",",".");
                break;
            default:
                $value = number_format($val, 0);
                break;
        }
        return $value;
    }
}