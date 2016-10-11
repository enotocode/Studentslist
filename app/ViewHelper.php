<?php
namespace app;
class ViewHelper
{
    public static function  markSameStr($str, $mask, $htmlTag = "<mark>%s</mark>")
    {
        if ($str == $mask) {
            return sprintf($htmlTag, $str);
        }      
        return $str;
    }
    public static function html($text)
    {
        return htmlspecialchars($text, ENT_QUOTES);
    }
}

