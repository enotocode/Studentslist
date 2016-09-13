<?php
namespace app;
class Abiturient
{
      
    private $name = "";
    private $lastName = "";
    private $gender = NULL;  
    private $groupNum = "";
    private $email = "";
    private $egePoints = "";
    private $dateOfBirth = "";
    private $registry = NULL; 
    private $userPassword = NULL;   
    
    public function __construct(array $values)
    {
        // Устанавливаем свойства в цикле, если поле с именем свойства существует
        foreach ($values as $propertyName=>$value) {
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }
    
    // Получение свойств объекта через вызов магического метода
    public function __call($methodName, $argument)
    {
        $args = preg_split('/(?<=\w)(?=[A-Z])/', $methodName);        
        $action = array_shift($args);
        $propertyName = lcfirst(implode($args));
 
        switch ($action) {
           case 'get' :
                if (isset($this->$propertyName)) {
                    return $this->$propertyName;
                } else {
                    return NULL;
                };
            case 'set' :
                if (!isset($this->$propertyName)) {
                    $this->$propertyName = $argument[0];
                    return TRUE;
                } else {
                    return NULL;
                };
        }
    }
}