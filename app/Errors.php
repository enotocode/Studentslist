<?php
namespace app;
class Errors
{
    private $errors = array();
    
    public function __construct()
    {        
    }    
    public function add($name, $descrip)
    {
        $this->errors[$name] = $descrip;      
    }
    public function get($name)
    {
        if (isset($this->errors[$name])) {
            return $this->errors[$name];
        }
        return FALSE;
    }
    public function isEmpty()
    {
        foreach($this->errors as $error) {
            if ($error) {
                return FALSE;
            }
        }
        return TRUE;
    }
}
