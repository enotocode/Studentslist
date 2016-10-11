<?php
namespace app;
class View
{
    public function __construct()
    {
        
    }    
    public function render($tmpl, Array $values = array())
    {        
        extract($values, EXTR_SKIP);
        require(__DIR__ . "/../templates/" . $tmpl);
    }
}