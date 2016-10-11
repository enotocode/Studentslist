<?php
namespace app;
class Abiturient
{
    // Константы
    const GENDER_MALE = "GENDER_MALE";
    const GENDER_FEMALE = "GENDER_FEMALE";
    const REGISTRY_LOCAL = "REGISTRY_LOCAL";
    const REGISTRY_NOT_LOCAL = "REGISTRY_NOT_LOCAL";
    
    public $name = "";
    public $lastName = "";
    public $gender = NULL;  
    public $groupNum = "";
    public $email = "";
    public $egePoints = "";
    public $dateOfBirth = "";
    public $registry = NULL; 
    public $userPassHash = NULL;   
    
    public function __construct()
    {
    }    
    // Обновление свойств из массива
    public function updateValues(Array $values)
    {
        // Устанавливаем свойства в цикле, если поле с именем свойства существует
        foreach ($values as $propertyName=>$value) {
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }
}