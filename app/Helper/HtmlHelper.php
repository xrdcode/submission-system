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
    public static function linkButton($text, $href, $class, $attr, $icon = false) {
        if($icon) {
            return '<a href="'. $href . '" class="btn ' . $class . '"' . $attr . '><i class="glyphicon ' . $icon . '"></i> ' . $text . '</a>';
        } else {
            return '<a href="'. $href . '" class="btn ' . $class . '"' . $attr . '>' . $text . '</a>';
        }
    }

    public static function toggleButton($active, array $attribute) {
        $fullattr = join(" ", $attribute);
        if($active) $checked = "";
        else $checked="checked=''";
        $toggle = "<label class=\"toggle\">
			  <input {$checked} type=\"checkbox\" {$fullattr} >
			  <span class=\"handle\"></span>
			</label>";

        return $toggle;
    }

    public static function selectList(array $arraylist = [], $selected = null, $name = '', $class = '', array $attribute = []) {
        $html = "<select name='{$name}' class='{$class}' " . self::join_attr($attribute) . ">";
        foreach($arraylist as $i => $v) {
            if($i == $selected)
                $html .= "<option value='{$i}' selected>{$v}</option>";
            else
                $html .= "<option value='{$i}'>{$v}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    public static function createTag($tag, array $class = [], array $attributes = [], $htmlval = '') {
        $html  = "";
        $html .= "<{$tag} ";
        if(!empty($class))
            $html .= "class='" . join(" ", $class) . "' ";
        $html .= self::join_attr($attributes);
        $html .= ">";
        $html .= $htmlval;
        $html .= "</{$tag}>";
        return $html;
    }

    public static function alert($title = "", $message = "", $class, $closable = true) {
        $close_class = "";
        $close_btn = "";
        if($closable){
            $close_class = "alert-dismissable";
            $close_btn = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>";
        }

        $message = <<<EOF
    <div class="alert {$class} {$close_class}">
                        {$close_btn}
                        <h4>{$title}</h4>
                        <p>{$message}</p>
                    </div>
EOF;
        return $message;
    }


    protected static function join_attr(array $arr) {
        return join(" ", array_map(
            function(&$v, $k) {
                return $v = "{$k}='{$v}'";
            },
            $arr,
            array_keys($arr)
        ));
    }

}