<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 15:09
 */

namespace App\Helper;


class HtmlHelper
{
    public static function linkButton($text, $href, $class, $icon = false) {
        if($icon) {
            return '<a href="'. $href . '" class="btn ' . $class . ' "><i class="glyphicon ' . $icon . '"></i> ' . $text . '</a>';
        } else {
            return '<a href="'. $href . '" class="btn ' . $class . '">' . $text . '</a>';
        }
    }

}