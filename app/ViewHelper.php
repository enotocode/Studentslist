<?php
namespace app;
class ViewHelper
{
    public static function  highlightSymbols($str, $mask, $htmlTag = "<strong><\strong>")
    {        
        $mask = preg_replace (
                                array("![^a-zA-ZА-Яа-я0-9\\s]!ui", "! +!ui"),
                                array("", " "),
                                $mask
                                );
        $mask = "/" . $mask . "/iu";
        preg_match("!(<\\w+>)(<\\/\\w+>)!ui", $htmlTag, $htmlTags);
        return preg_replace($mask, "{$htmlTags[1]}$0{$htmlTags[2]}", $str);
    }
    public static function html($text)
    {
        return htmlspecialchars($text, ENT_QUOTES);
    }
}

