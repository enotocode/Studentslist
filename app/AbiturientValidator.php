<?php
namespace app;
class AbiturientValidator
{
    private $errors = array();
    
    public function findForbiddenSymbols($regExp, $value)
    {
        $value = mb_check_encoding($value, 'UTF-8') ? $value : utf8_encode($value);
        preg_match_all($regExp, $value, $forbiddenSymbols, PREG_PATTERN_ORDER);
        if (!empty($forbiddenSymbols[0])) {
            $forbiddenSymbols = '"' . implode('", "',$forbiddenSymbols[0]) . '"';
            return $forbiddenSymbols;
        }
        return NULL;
    }
    public function validateEmail($value)    {       
        $email = filter_var ($value, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            return $value;
        }
        return NULL;
    }
    
    public function validateLenght($value, $maxLength, $minLength = 0)
    {
        if (mb_strlen($value)>$maxLength | mb_strlen($value)<$minLength) {
            return mb_strlen($value);
        }  
        return NULL;
    }
    public function validateIntForMaxMin($value, $max, $min = 0)
    {
        if ($value>$max | $value<$min) {
            return $value;
        }  
        return NULL;
    }
    public function validateBoolean($value)
    {
        if ($value != 0 && $value != 1) {
            return $value;
        }  
        return NULL;
    } 
    public function validate(Abiturient $abiturient)
    {        
        // Имя
        $name = $abiturient->getName();      
        $this->errors["name"][0] = $this->findForbiddenSymbols('/[^a-zа-яё]/ui', $name);
        $this->errors["name"][1] = $this->validateLenght($name, 90); 
        // Фамилия 
        $lastName = $abiturient->getLastName();
        $this->errors["lastName"][0] = $this->findForbiddenSymbols('/[^a-zа-яё\-\']/ui', $lastName);
        $this->errors["lastName"][1] = $this->validateLenght($lastName, 90);
        // Пол
        $gender = $abiturient->getGender();
        $this->errors["gender"] = $this->validateBoolean($gender);
        // Номер группы
        $groupNum = $abiturient->getGroupNum();
        $this->errors["groupNum"][0] = $this->findForbiddenSymbols('/[^a-zа-яё0-9\-]/ui', $groupNum);
        $this->errors["groupNum"][1] = $this->validateLenght($groupNum, 10, 2); // строка, макс длина, мин длина
        // Email
        $email = $abiturient->getEmail();
        $this->errors["email"] = $this->validateEmail($email);    
        // Суммарное количество баллов ЕГЭ
        $egePoints = $abiturient->getEgePoints();
        $this->errors["egePoints"][0] = $this->findForbiddenSymbols('/[^0-9]/u', $egePoints);
        $this->errors["egePoints"][1] = $this->validateIntForMaxMin($egePoints, 400);          
        // Год рождения
        $dateOfBirth = $abiturient->getDateOfBirth();
        $this->errors["dateOfBirth"][0] = $this->findForbiddenSymbols('/[^0-9]/u', $dateOfBirth);
        date_default_timezone_set('UTC'); // установка временной зоны по умолчанию
        $this->errors["dateOfBirth"][1] = $this->validateIntForMaxMin($dateOfBirth, date("Y"), 1900);
        // Прописка (местная)
        $registry = $abiturient->getRegistry();
        $this->errors["registry"] = $this->validateBoolean($registry);
        
        return $this->errors;
    }  
}

